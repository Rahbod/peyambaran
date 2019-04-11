<?php

namespace app\controllers;

use app\models\PictureGallery;
use app\models\VideoGallery;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use devgroup\dropzone\UploadedFiles;
use Yii;
use app\models\Gallery;
use app\models\GallerySearch;
use app\components\AuthController;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * GalleryController implements the CRUD actions for Gallery model.
 */
class GalleryController extends AuthController
{
    public $defaultAction = 'show';

    public $imageDir = 'uploads/gallery';
    public $videoDir = 'uploads/gallery/video';
    private $posterOptions = ['thumbnail' => ['width' => 270, 'height' => 190, 'replaceOrigin' => true]];
    private $thumbOptions = ['thumbnail' => ['width' => 160, 'height' => 90, 'replaceOrigin' => true]];
    private $fullImageOptions = ['thumbnail' => ['width' => 280, 'height' => 380]];

    /**
     * for set admin theme
     */
    public function init()
    {
        $this->setTheme('default');
        parent::init();
    }

    public function getMenuActions()
    {
        return [
            'show',
//            'video',
        ];
    }

    public function getSystemActions()
    {
        return [
            'upload-image',
            'delete-image',
            'upload-video',
            'delete-video',
            'upload-thumb',
            'delete-thumb',
            'upload-full-image',
            'delete-full-image',
            'show',
            'video',
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
            /* Video Gallery Actions */
            'upload-image' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new VideoGallery(), 'image'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-image' => [
                'class' => RemoveAction::className(),
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new VideoGallery(),
                'attribute' => 'image',
                'upload' => $this->imageDir,
                'options' => $this->posterOptions
            ],
            'upload-video' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new VideoGallery(), 'video'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('mp4')
                )
            ],
            'delete-video' => [
                'class' => RemoveAction::className(),
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new VideoGallery(),
                'attribute' => 'video',
                'upload' => $this->videoDir
            ],
            /* Picture Gallery Actions */
            'upload-thumb' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new PictureGallery(), 'thumbnail_image'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-thumb' => [
                'class' => RemoveAction::className(),
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new PictureGallery(),
                'attribute' => 'thumbnail_image',
                'upload' => $this->imageDir,
                'options' => $this->thumbOptions
            ],
            'upload-full-image' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new PictureGallery(), 'full_image'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-full-image' => [
                'class' => RemoveAction::className(),
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new PictureGallery(),
                'attribute' => 'full_image',
                'upload' => $this->imageDir,
                'options' => $this->fullImageOptions
            ]
        ];
    }

    /**
     * Lists all Gallery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GallerySearch();

        $searchModel->type = Gallery::TYPE_PICTURE_GALLERY;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionShow()
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);
        $searchModel = new GallerySearch();

        $searchModel->type = Gallery::TYPE_PICTURE_GALLERY;
//        $searchModel->status = Gallery::STATUS_PUBLISHED;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('show', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVideo()
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);
        $searchModel = new GallerySearch();

        $searchModel->type = Gallery::TYPE_VIDEO_GALLERY;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('show', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Gallery model.
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
     * Creates a new Gallery model.
     * If creation is successful, the browser will be redirected to the 'view' gallery.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PictureGallery();

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $thumb = new UploadedFiles($this->tmpDir, $model->thumbnail_image, $this->thumbOptions);
            $fullImage = new UploadedFiles($this->tmpDir, $model->full_image, $this->fullImageOptions);
            if ($model->save()) {
                $thumb->move($this->imageDir);
                $fullImage->move($this->imageDir);
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('create', [
            'model' => $model,
            'thumb' => $thumb?:[],
            'fullImage' => $fullImage?:[],
        ]);
    }

    /**
     * Updates an existing Gallery model.
     * If update is successful, the browser will be redirected to the 'view' gallery.
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

        $thumb = new UploadedFiles($this->imageDir, $model->thumbnail_image, $this->thumbOptions);
        $fullImage = new UploadedFiles($this->imageDir, $model->full_image, $this->fullImageOptions);

        if (Yii::$app->request->post()) {
            $oldThumb = $model->thumbnail_image;
            $oldFullImage = $model->full_image;
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                $thumb->update($oldThumb, $model->thumbnail_image, $this->tmpDir);
                $fullImage->update($oldFullImage, $model->full_image, $this->tmpDir);
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('update', [
            'model' => $model,
            'thumb' => $thumb,
            'fullImage' => $fullImage,
        ]);
    }


    /*************  Video Gallery Actions  **************/

    /**
     * Lists all Gallery models.
     * @return mixed
     */
    public function actionIndexVideo()
    {
        $searchModel = new GallerySearch();

        $searchModel->type = Gallery::TYPE_VIDEO_GALLERY;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_video', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Gallery model.
     * If creation is successful, the browser will be redirected to the 'view' gallery.
     * @return mixed
     */
    public function actionCreateVideo()
    {
        $model = new VideoGallery();

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $poster = new UploadedFiles($this->tmpDir, $model->image, $this->posterOptions);
            $video = new UploadedFiles($this->tmpDir, $model->video);
            if ($model->save()) {
                $poster->move($this->imageDir);
                $video->move($this->videoDir);
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('create_video', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Gallery model.
     * If update is successful, the browser will be redirected to the 'view' gallery.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateVideo($id)
    {
        $model = $this->findVideoModel($id);

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $poster = new UploadedFiles($this->imageDir, $model->image, $this->posterOptions);
        $video = new UploadedFiles($this->videoDir, $model->video);

        if (Yii::$app->request->post()) {
            $oldPoster = $model->image;
            $oldVideo = $model->video;
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                $poster->update($oldPoster, $model->image, $this->tmpDir);
                $video->update($oldVideo, $model->video, $this->tmpDir);
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('update_video', [
            'model' => $model,
            'poster' => $poster,
            'video' => $video,
        ]);
    }

    /****************  END  **********************/

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->type == Gallery::TYPE_PICTURE_GALLERY) {
            $image = new UploadedFiles($this->imageDir, $model->thumbnail_image, $this->thumbOptions);
            $image->removeAll(true);
            $image = new UploadedFiles($this->imageDir, $model->full_image, $this->fullImageOptions);
            $image->removeAll(true);
        } elseif ($model->type == Gallery::TYPE_VIDEO_GALLERY) {
            $image = new UploadedFiles($this->imageDir, $model->image, $this->posterOptions);
            $image->removeAll(true);
            $video = new UploadedFiles($this->videoDir, $model->video);
            $video->removeAll(true);
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Gallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PictureGallery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PictureGallery::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('words', 'The requested gallery does not exist.'));
    }

    /**
     * Finds the Gallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VideoGallery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findVideoModel($id)
    {
        if (($model = VideoGallery::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('words', 'The requested gallery does not exist.'));
    }
}
