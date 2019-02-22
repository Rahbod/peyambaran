<?php

namespace app\controllers;

use Yii;
use app\models\Page;
use app\models\PageSearch;
use app\components\AuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends AuthController
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
                ],
            ],
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
            \app\components\dd($model->created);
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
     * Deletes an existing Page model.
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
