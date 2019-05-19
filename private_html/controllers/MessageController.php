<?php

namespace app\controllers;

use function app\components\dd;
use app\models\Department;
use app\models\DepartmentSearch;
use Yii;
use app\models\Message;
use app\models\MessageSearch;
use app\components\AuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends AuthController
{
    /**
    * for set admin theme
    */
    public function init()
    {
        $this->setTheme('default');
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-department' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionContactus()
    {
        $searchModel = new MessageSearch();
        $searchModel->type = Message::TYPE_CONTACT_US;
        if(Yii::$app->request->getQueryParam('id'))
            $searchModel->department_id = Yii::$app->request->getQueryParam('id');

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionSuggestions()
    {
        $searchModel = new MessageSearch();
        $searchModel->type = Message::TYPE_SUGGESTIONS;
        if(Yii::$app->request->getQueryParam('id'))
            $searchModel->department_id = Yii::$app->request->getQueryParam('id');

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionComplaints()
    {
        $searchModel = new MessageSearch();
        $searchModel->type = Message::TYPE_COMPLAINTS;
        if(Yii::$app->request->getQueryParam('id'))
            $searchModel->department_id = Yii::$app->request->getQueryParam('id');

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Message model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Message();

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()){
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['view', 'id' => $model->id]);
            }else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()){
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['view', 'id' => $model->id]);
            }else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('words', 'The requested page does not exist.'));
    }

    protected function findModelDepartment($id)
    {
        if (($model = Department::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('words', 'The requested page does not exist.'));
    }

    public function actionDepartment()
    {
        $searchModel = new DepartmentSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('department', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreateDepartment()
    {
        $model = new Department();

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $saveResult = false;
            $parentID = $model->parentID;
            if ($parentID == '') {
                $saveResult = $model->makeRoot();
                $model->parentID = null;
            } else {
                $parent = Department::findOne($parentID);
                $saveResult = $model->prependTo($parent);
            }
            if ($saveResult) {
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['department']);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('create_department', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Department model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateDepartment($id)
    {
        $model = $this->findModelDepartment($id);
        $parent = $model->parents(1)->one();
        $children = $model->children()->all();

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());

            $saveResult = false;
            $parentID = $model->parentID;
            $model->parentID = null;
            if ($parentID == '') {
                if ($parent)
                    $saveResult = $model->makeRoot();
                else
                    $saveResult = $model->save();
            } else {
                $newParent = Department::findOne($parentID);
                $saveResult = $model->appendTo($newParent);
            }

            if ($saveResult) {
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['department']);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }
        if ($parent)
            $model->parentID = $parent->id;

        return $this->render('update_department', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Department model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteDepartment($id)
    {
        $result = $this->findModelDepartment($id);
        $result = $result->deleteWithChildren();

        if ($result === false)
            Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.deleteDangerMsg')]);
        else
            Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.deleteSuccessMsg')]);


        return $this->redirect(['department']);
    }
}
