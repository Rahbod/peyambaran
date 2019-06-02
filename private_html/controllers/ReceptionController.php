<?php

namespace app\controllers;

use app\components\Helper;
use app\components\SmsSender;
use app\models\Attachment;
use app\models\Reception;
use app\models\ReceptionSearch;
use app\models\UserRequest;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use devgroup\dropzone\UploadedFiles;
use Yii;
use app\components\AuthController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ReceptionController implements the CRUD actions for Reception model.
 */
class ReceptionController extends AuthController
{
    public static $attachmentOptions = [];

    public function getSystemActions()
    {
        return [
            'delete',
            'list',
            'request',
            'view',
            'upload-attachment',
            'delete-attachment',
        ];
    }

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
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'upload-attachment' => [
                'class' => UploadAction::className(),
                'rename' => UploadAction::RENAME_UNIQUE,
                'modelName' => 'Reception',
                'model' => new Reception(),
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx')
                )
            ],
            'delete-attachment' => [
                'class' => RemoveAction::className(),
                'upload' => Attachment::$attachmentPath,
                'storedMode' => RemoveAction::STORED_RECORD_MODE,
                'model' => new Attachment(),
                'attribute' => 'file',
                'options' => static::$attachmentOptions
            ],
        ];
    }

    /**
     * Lists all Reception models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReceptionSearch();

        if(Yii::$app->user->identity->reception_type)
            $searchModel->reception_type = Yii::$app->user->identity->reception_type;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Reception models.
     * @return mixed
     */
    public function actionList()
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);
        $this->layout = 'dashboard';

        $searchModel = new ReceptionSearch();
        $searchModel->userID = Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRequest()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->returnUrl = Yii::$app->request->getAbsoluteUrl();
            return $this->redirect(['/user/login']);
        }

        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);
        $this->layout = 'dashboard';

        $model = new Reception();
        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $files = new UploadedFiles($this->tmpDir, $model->files, static::$attachmentOptions);
            if ($model->save()) {
                $files->move(Attachment::getAttachmentPath());
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['list']);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('request', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Reception model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->isGuest)
            throw new ForbiddenHttpException('شما مجوز انجام این عملیات را ندارید.');

        if (Yii::$app->user->identity->roleID === 'user') {
            $this->setTheme('frontend', ['bodyClass' => 'innerPages']);
            $this->layout = 'dashboard';
            $admin = false;
        } else {
            $model->status = $model->status === UserRequest::STATUS_PENDING ? UserRequest::STATUS_OPERATOR_CHECK : $model->status;
            $model->save();
            $admin = true;
        }

        return $this->render('view', [
            'model' => $model,
            'admin' => $admin
        ]);
    }

//    /**
//     * Creates a new Reception model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     * @return mixed
//     */
//    public function actionCreate()
//    {
//        $model = new Reception();
//
//        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
//            $model->load(Yii::$app->request->post());
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ActiveForm::validate($model);
//        }
//
//        if (Yii::$app->request->post()) {
//            $model->load(Yii::$app->request->post());
//            if ($model->save()) {
//                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
//                return $this->redirect(['view', 'id' => $model->id]);
//            } else
//                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }
//
    /**
     * Updates an existing Reception model.
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

        if (Yii::$app->request->post()) {
            $oldVisit = $model->visit_date;
            $model->load(Yii::$app->request->post());
            $date = null;
            if ($model->visit_date) {
                $date = $model->visit_date;
                $model->visit_date = (string)Helper::jDateTotoGregorian($model->visit_date);
                $model->status = UserRequest::STATUS_CONFIRM;
            }

            if ($model->save()) {

                if ($model->visit_date) {
                    if (!$oldVisit)
                        SmsSender::Send(SmsSender::$afterReceptionTemplate, $model->user->phone, $model->getReceptionTypeLabel(),
                            \jDateTime::date('Y/m/d', $model->visit_date));
                    elseif($oldVisit!=$model->visit_date)
                        SmsSender::Send(SmsSender::$afterChangeReceptionTemplate, $model->user->phone, $model->getReceptionTypeLabel(),
                            \jDateTime::date('Y/m/d', $model->visit_date));
                }

                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
            $model->visit_date = $date;
        }

        return $this->render('view', [
            'model' => $model,
            'admin' => true,
        ]);
    }

    /**
     * Deletes an existing Reception model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (!Yii::$app->user->isGuest || Yii::$app->user->identity->roleID != 'user' ||
            (Yii::$app->user->identity->roleID == 'user' && Yii::$app->user->getId() === $model->userID)) {
            $model->delete();
        } else
            return $this->goBack();

        return $this->redirect([Yii::$app->user->identity->roleID != 'user' ? 'index' : 'list']);
    }

    /**
     * Finds the Reception model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reception the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reception::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('words', 'The requested page does not exist.'));
    }
}
