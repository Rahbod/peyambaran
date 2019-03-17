<?php

namespace app\controllers;

use richardfan\sortable\SortableAction;
use Yii;
use app\models\Category;
use app\models\CategorySearch;
use app\components\AuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends AuthController
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

    public function actions()
    {
        return [
            'sort-item' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => Category::className(),
                'orderColumn' => 'sort',
            ],
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()){
            $model->load(Yii::$app->request->post());
            $saveResult = false;
            $parentID = $model->parentID;
            if ($parentID == '') {
                $saveResult = $model->makeRoot();
                $model->parentID = null;
            } else {
                $parent = Category::findOne($parentID);
                $saveResult = $model->prependTo($parent);
            }
            if ($saveResult) {
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['view', 'id' => $model->id]);
            }else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

public function actionCreateGallery()
    {
        $parent = \app\models\Category::findOne(162);
        var_dump($parent->children()->count());exit;
        /*$newParent = new Category();
        $newParent->name = $parent->name;
        $newParent->category_type = 'image_gallery';
        if($newParent->makeRoot()){
            foreach($parent->children(1)->all() as $child){
                $newChild = new Category();
                $newChild->name = $child->name;
                $newChild->category_type = 'image_gallery';
                $newChild->parentID = $newParent->id;
                if($newChild->prependTo($newParent)){
                    foreach($child->children(1)->all() as $schild){
                        
                    $newSChild = new Category();
                $newSChild->name = $schild->name;
                $newSChild->category_type = 'image_gallery';
                $newSChild->parentID = $newChild->id;
                $newSChild->prependTo($newChild);
                    }
                }
                
            }
        }
        */



        if (Yii::$app->request->post()){
            $model->load(Yii::$app->request->post());
            $saveResult = false;
            $parentID = $model->parentID;
            if ($parentID == '') {
                $saveResult = $model->makeRoot();
                $model->parentID = null;
            } else {
                $parent = Category::findOne($parentID);
                $saveResult = $model->prependTo($parent);
            }
            if ($saveResult) {
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
     * Updates an existing Category model.
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
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $result = $this->findModel($id);
        $result = $result->deleteWithChildren();

        if ($result === false)
            Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.deleteDangerMsg')]);
        else
            Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.deleteSuccessMsg')]);


        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('words', 'The requested page does not exist.'));
    }
}
