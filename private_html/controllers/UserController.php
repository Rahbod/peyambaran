<?php

namespace app\controllers;

use app\components\AuthController;
use app\components\customWidgets\CustomCaptchaAction;
use app\models\LoginForm;
use app\models\UGroup;
use app\models\UserSearch;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use devgroup\dropzone\UploadedFiles;
use Yii;
use app\models\User;
use app\models\Role;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends AuthController
{
    public $avatarPath = 'uploads/users/avatars';

    public function init()
    {
        $this->setTheme('default');
        parent::init();
    }

    /**
     * Returns actions that excluded from user roles
     * @return array
     */
    public function getSystemActions()
    {
        return [
            'upload-image',
            'delete-image',
            'login',
            'logout',
            'register',
            'forgetPassword',
            'changePassword',
            'dashboard',
            'captcha'
        ];
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

    public function actions()
    {
        return [
            'captcha' => [
                'class' => CustomCaptchaAction::className(),
                'width' => 130,
                'height' => 40,
                'transparent' => true
            ],
            // declares "error" action using a class name
            'upload-image' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new User(), 'image'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-image' => [
                'class' => RemoveAction::className(),
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new User(),
                'attribute' => 'image',
                'upload' => $this->avatarPath
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->setScenario('insert');

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                $auth = Yii::$app->authManager;
                $role = $auth->getRole($model->roleID);
                $auth->assign($role, $model->id);
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        $roles = ArrayHelper::map(Role::validQuery()->all(), 'name', 'description');
        $groups = ArrayHelper::map(UGroup::validQuery()->all(), 'id', 'name');

        return $this->render('create', [
            'model' => $model,
            'roles' => $roles,
            'groups' => $groups,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->groups = ArrayHelper::map($model->ugroups, 'id', 'name');

        $storedFiles = new UploadedFiles($this->avatarPath, $model->image);

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $oldRole = $model->roleID;
            // store model image value in oldImage variable
            $oldImage = $model->image;
            // load post values in model
            $model->load(Yii::$app->request->post());

            if ($model->save()) {
                $storedFiles->update($oldImage, $model->image, $this->tmpDir);

                $auth = Yii::$app->authManager;
                if ($oldRole != $model->roleID) {
                    $auth->revoke($auth->getRole($oldRole), $model->id);
                    $auth->assign($auth->getRole($model->roleID), $model->id);
                }

                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        $roles = ArrayHelper::map(Role::validQuery()->all(), 'name', 'description');
        $groups = ArrayHelper::map(UGroup::validQuery()->all(), 'id', 'name');

        return $this->render('update', [
            'model' => $model,
            'roles' => $roles,
            'groups' => $groups,
            'storedFiles' => $storedFiles
        ]);
    }

    /**
     * Deletes an existing User model.
     * @return mixed
     */
    public function actionDelete()
    {
        $result = false;
        if (Yii::$app->request->post('Delete')) {
            $data = Yii::$app->request->post('Delete');
            switch ($data['type']) {
                case 'single':
//                    'delete-user'
                    $model = $this->findModel($data['id']);
                    if ($model) {
                        if ($model->status)
                            $model->scenario = 'delete-user';
                        $model->status = User::STATUS_DELETED;
                        $result = $model->save(false);
                    }
                    break;

                case 'multiple':
                    $result = true;
                    foreach (User::findAll(['id' => Json::decode($data['id'])]) as $model) {
                        $model->scenario = 'delete-user';
                        $model->status = User::STATUS_DELETED;
                        @$model->save(false);
                    }
                    break;
            }
        }

        if ($result === false)
            Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.deleteDangerMsg')]);
        else
            Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.deleteSuccessMsg')]);

        return $this->actionIndex();
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionChangePassword()
    {
        $model = $this->findModel(Yii::$app->user->id);
        $model->setScenario('change-password');

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                $this->redirect(['/admin/index']);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);

        }

        return $this->render('change_pass', compact('model'));
    }


    public function actionLogin()
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionRegister()
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);

        $model = new User();
        $model->setScenario('register');

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $model->username = $model->phone;
            $model->password = $model->nationalCode;
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->refresh();
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }


        return $this->render('register', compact('model'));
    }

    public function actionForgetPassword()
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);
        \app\components\dd(1);
    }

    public function actionDashboard()
    {
        if (Yii::$app->user->isGuest)
            return $this->redirect(['/']);
        $this->setTheme('frontend', ['headerClass' => '-blueHeader']);
        $user = Yii::$app->user->identity;
        return $this->render('dashboard', compact('user'));

    }
}
