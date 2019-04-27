<?php

namespace app\controllers;

use app\components\MainController;
use app\components\Setting;
use app\models\Item;
use app\models\RoleSearch;
use Yii;
use app\models\Role;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\components\AuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends AuthController
{

    public function init()
    {
        $this->setTheme('default');
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role();
        $model->name = substr(uniqid(), 0, 64);

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $auth = Yii::$app->authManager;
            $data = Yii::$app->request->post('Role');
            $actions = Yii::$app->request->post('actions');
            $role = $auth->createRole($data['name']);
            $role->description = $data['description'];
            if ($auth->add($role)) {
                if ($actions) {
                    foreach ($actions as $action) {
                        if (strpos($action, '-') !== false) {
                            $permission = explode('-', $action);
                            $permissionName = $permission[0] . ucfirst($permission[1]);
                            $permission = $auth->getPermission($permissionName);
                            if (is_null($permission)) {
                                $permission = $auth->createPermission($permissionName);
                                $auth->add($permission);
                            }
                            $auth->addChild($role, $permission);
                        }
                    }
                }

                if (!empty($data['parent'])) {
                    $parent = $auth->getRole($data['parent']);
                    $auth->addChild($parent, $role);
                }

                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        $actions = $this->getAllActions();
        $actions = $this->prepareForView($actions);

        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        unset($roles['superAdmin']);
        $roles = ArrayHelper::map($roles, 'name', function ($model) {
            return ($model->description == 'Guest Role' ? Yii::t('words', 'Guest Role') : $model->description);
        });

        return $this->render('create', [
            'model' => $model,
            'actions' => $actions,
            'roles' => $roles,
        ]);
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $auth = Yii::$app->authManager;
        $role = $auth->getRole($model->name);
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post('Role');
            if (isset($data['name'])) unset($data['name']);

            $role->description = $data['description'];
            /* @var Role[] $children */
            $children = $model->getChildren()->where(['type' => 1])->all();
            if ($auth->update($model->name, $role)) {
                // Remove all permissions
                $auth->removeChildren($role);
                if (Yii::$app->request->post('actions')) {
                    // Add new permissions
                    $actions = Yii::$app->request->post('actions');
                    foreach ($actions as $action) {
                        if (strpos($action, '-') !== false) {
                            $permission = explode('-', $action);
                            $permissionName = $permission[0] . ucfirst($permission[1]);
                            $permission = $auth->getPermission($permissionName);
                            if (is_null($permission)) {
                                $permission = $auth->createPermission($permissionName);
                                $auth->add($permission);
                            }
                            $auth->addChild($role, $permission);
                        }
                    }
                }

                if (!empty($data['parent'])) {
                    $parent = $auth->getRole($data['parent']);
                    $auth->addChild($parent, $role);
                }

                if ($children) {
                    $parent = $role;
                    foreach ($children as $child) {
                        $childRole = $auth->getRole($child->name);
                        $auth->addChild($parent, $childRole);
                    }
                }
                $model->load(Yii::$app->request->post());
                $model->save();
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->refresh();
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        $actions = $this->getAllActions();
        $actions = $this->prepareForView($actions, array_keys($auth->getPermissionsByRole($role->name)), null);

        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        unset($roles[$role->name]);
        unset($roles['superAdmin']);
        $roles = ArrayHelper::map($roles, 'name', 'description');

        return $this->render('update', [
            'model' => $model,
            'actions' => $actions,
            'roles' => $roles,
        ]);
    }

    /**
     * Deletes an existing Role model.
     * @return mixed
     */
    public function actionDelete($id)
    {
        $result = false;
        $auth = Yii::$app->authManager;
        if ($id == 'superAdmin' || $id == 'admin')
            $result = true;
        else {
            $role = $auth->getRole($id);
            $result = $auth->remove($role);
        }

        if ($result === false)
            Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.deleteDangerMsg')]);
        else {
            Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.deleteSuccessMsg')]);
            $this->redirect(['/role/index']);
        }
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSetDefault($id)
    {
        Setting::set('defaultRole', $id);
        $this->actionIndex();
    }
}
