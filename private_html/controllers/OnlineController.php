<?php

namespace app\controllers;

use app\models\OnlineService;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use devgroup\dropzone\UploadedFiles;
use richardfan\sortable\SortableAction;
use Yii;
use app\models\Menu;
use app\models\OnlineServiceSearch;
use app\components\AuthController;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * OnlineController implements the CRUD actions for Menu model.
 */
class OnlineController extends AuthController
{
    public $iconDir = 'uploads/online';
    private $iconOptions = ['resize' => ['width' => 100, 'height' => 100]];

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
            'reception',
            'cooperation',
            'advice',
        ];
    }

    public function getSystemActions()
    {
        return [
            'advice',
            'cooperation',
            'reception',
            'upload-icon',
            'delete-icon',
            'upload-icon-hover',
            'delete-icon-hover',
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
            'sort-item' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => Menu::className(),
                'orderColumn' => 'sort',
            ],
            'upload-icon' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new OnlineService(), 'icon'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg', 'svg')
                )
            ],
            'delete-icon' => [
                'class' => RemoveAction::className(),
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new OnlineService(),
                'attribute' => 'icon',
                'upload' => $this->iconDir
            ],
            'upload-icon-hover' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new OnlineService(), 'hover_icon'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg', 'svg')
                )
            ],
            'delete-icon-hover' => [
                'class' => RemoveAction::className(),
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new OnlineService(),
                'attribute' => 'hover_icon',
                'upload' => $this->iconDir
            ],
        ];
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OnlineServiceSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
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
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OnlineService();

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $icon = new UploadedFiles($this->tmpDir, $model->icon, $this->iconOptions);
            $hoverIcon = new UploadedFiles($this->tmpDir, $model->hover_icon, $this->iconOptions);
            if ($model->save()) {
                $icon->move($this->iconDir);
                $hoverIcon->move($this->iconDir);
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['index']);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('create', compact('model', 'icon', 'hoverIcon'));
    }

    /**
     * Updates an existing Menu model.
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

        $icon = new UploadedFiles($this->iconDir, $model->icon, $this->iconOptions);
        $hoverIcon = new UploadedFiles($this->iconDir, $model->hover_icon, $this->iconOptions);

        if (Yii::$app->request->post()) {
            $oldIcon = $model->icon;
            $oldHoverIcon = $model->hover_icon;
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                $icon->update($oldIcon, $model->icon, $this->tmpDir);
                $hoverIcon->update($oldHoverIcon, $model->hover_icon, $this->tmpDir);
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('update', compact('model', 'icon', 'hoverIcon'));
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $icon = new UploadedFiles($this->iconDir, $model->icon, $this->iconOptions);
        $hoverIcon = new UploadedFiles($this->iconDir, $model->hover_icon, $this->iconOptions);
        $icon->removeAll(true);
        $hoverIcon->removeAll(true);
        if ($model->delete())
            Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.deleteSuccessMsg')]);
        else
            Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.deleteDangerMsg')]);


        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OnlineService::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('words', 'The requested page does not exist.'));
    }


    public function actionAdvice()
    {
        $url = '/advice/request';
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->roleID != 'user')
            return $this->redirect(['/user/login', 'return' => $url]);
        return $this->redirect([$url]);
    }
    public function actionCooperation()
    {
        $url = '/cooperation/request';
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->roleID != 'user')
            return $this->redirect(['/user/login', 'return' => $url]);
        return $this->redirect([$url]);
    }
    public function actionReception()
    {
        $url = '/reception/request';
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->roleID != 'user')
            return $this->redirect(['/user/login', 'return' => $url]);
        return $this->redirect([$url]);
    }
}
