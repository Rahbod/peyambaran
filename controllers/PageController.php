<?php

namespace app\controllers;

use app\components\DynamicActiveRecord;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use devgroup\dropzone\UploadedFiles;
use Yii;
use app\models\Page;
use app\models\PageSearch;
use app\components\AuthController;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends AuthController
{
    public $imageDir = 'uploads/pages';
    private $imageOptions = [];

    /**
    * for set admin theme
    */
    public function init()
    {
        $this->setTheme('default');
        parent::init();
    }

    public function getSystemActions()
    {
        return [
            'uploadImage',
            'deleteImage',
        ];
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
            'upload-image' => [
                'class' => UploadAction::className(),
                'upload' => $this->imageDir,
                'fileName' => Html::getInputName(new Page(), 'image'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-image' => [
                'class' => RemoveAction::className(),
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Page(),
                'attribute' => 'image',
                'upload' => $this->imageDir
            ]
        ];
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Page model.
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
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()){
            $model->load(Yii::$app->request->post());
            $image = new UploadedFiles($this->tmpDir, $model->image, $this->imageOptions);
            if ($model->save()) {
                $image->move($this->imageDir);
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
     * Updates an existing Page model.
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

        $image = new UploadedFiles($this->imageDir, $model->image, $this->imageOptions);

        if (Yii::$app->request->post()){
            $oldImage = $model->image;
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                $image->update($oldImage, $model->image, $this->tmpDir);
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['view', 'id' => $model->id]);
            }else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('update', [
            'model' => $model,
            'image' => $image,
        ]);
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $image = new UploadedFiles($this->imageDir, $model->image, $this->imageOptions);
        $image->removeAll(true);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('words', 'The requested page does not exist.'));
    }
}
