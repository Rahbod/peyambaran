<?php

namespace app\controllers;

use app\models\Attachment;
use app\models\Cooperation;
use app\models\CooperationSearch;
use app\models\UserRequest;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use devgroup\dropzone\UploadedFiles;
use faravaghi\jalaliDatePicker\jalaliDatePicker;
use Yii;
use app\components\AuthController;
use yii\helpers\Html;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * CooperationController implements the CRUD actions for Cooperation model.
 */
class CooperationController extends AuthController
{
    public static $avatarPath = 'uploads/cooperation/avatars';
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
            'upload-avatar',
            'delete-avatar',
            'fetchDynamicRow',
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
                'modelName' => 'Cooperation',
                'model' => new Cooperation(),
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
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
            'upload-avatar' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new Cooperation(), 'avatar'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-avatar' => [
                'class' => RemoveAction::className(),
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Cooperation(),
                'attribute' => 'avatar',
                'upload' => static::$avatarPath
            ],
        ];
    }

    /**
     * Lists all Cooperation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CooperationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Cooperation models.
     * @return mixed
     */
    public function actionList()
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);
        $this->layout = 'dashboard';

        $searchModel = new CooperationSearch();
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

        $model = new Cooperation();
        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
//            \app\components\dd(Yii::$app->request->post());
            $model->load(Yii::$app->request->post());
            $avatar = new UploadedFiles($this->tmpDir, $model->avatar);
            $files = new UploadedFiles($this->tmpDir, $model->files, static::$attachmentOptions);
            if ($model->save()) {
                $avatar->move(static::$avatarPath);
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
     * Displays a single Cooperation model.
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

    /**
     * Creates a new Cooperation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Cooperation();
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
//    /**
//     * Updates an existing Cooperation model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param integer $id
//     * @return mixed
//     * @throws NotFoundHttpException if the model cannot be found
//     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cooperation model.
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

            if ($model->avatar) { // delete user avatar
                $avatar = new UploadedFiles(static::$avatarPath, $model->avatar);
                $avatar->removeAll(true);
            }

            $model->delete();
        } else
            return $this->goBack();

        return $this->redirect([Yii::$app->user->identity->roleID != 'user' ? 'index' : 'list']);
    }

    /**
     * Finds the Cooperation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cooperation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cooperation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('words', 'The requested page does not exist.'));
    }


    public function actionFetchDynamicRow()
    {
        $index = Yii::$app->request->getQueryParam('index');
        $attribute = Yii::$app->request->getQueryParam('attribute');

        if ($index && $attribute) {
            ob_start();
            ob_implicit_flush(false);
            switch ($attribute) {
                case 'job_history':
                    echo "<tr>
                        <td>" . Html::textInput("Cooperation[{$attribute}][{$index}][place]", '', ['class' => 'form-control', ]) . "</td>
                        <td>" . Html::textInput("Cooperation[{$attribute}][{$index}][type]", '', ['class' => 'form-control', ]) . "</td>
                        <td>";
                    echo jalaliDatePicker::widget([
                            'id' => "date_{$attribute}_".$index,
                            'name' => "Cooperation[{$attribute}][{$index}][end_date]",
                            'value' => null,
                            'ajax' => true,
                            'options' => [
                                'format' => 'yyyy/mm/dd',
                                'viewformat' => 'yyyy/mm/dd',
                                'placement' => 'right',
                            ],
                            'htmlOptions' => [
                                'class' => 'form-control',
                                'autocomplete' => 'off',
                                'placeholder' => '__/__/____'
                            ]
                        ]) . "</td>
                        <td>" . Html::textInput("Cooperation[{$attribute}][{$index}][cause]", '', ['class' => 'form-control', ]) . "</td>
                        <td>" . Html::textInput("Cooperation[{$attribute}][{$index}][contact]", '', ['class' => 'form-control', ]) . "</td>
                    </tr>";
                    break;
            }
            return ob_get_clean();
        }
        return "";
    }
}
