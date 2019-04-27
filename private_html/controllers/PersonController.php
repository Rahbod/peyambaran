<?php

namespace app\controllers;

use app\models\ClinicProgram;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use devgroup\dropzone\UploadedFiles;
use Yii;
use app\models\Person;
use app\models\PersonSearch;
use app\components\AuthController;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * PersonController implements the CRUD actions for Person model.
 */
class PersonController extends AuthController
{
    public $avatarDir = 'uploads/person';
    private $avatarOptions = [];

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

    public function getMenuActions()
    {
        return [
            'list'
        ];
    }

    public function getSystemActions()
    {
        return [
            'upload-avatar',
            'delete-avatar',
            'show',
            'list'
        ];
    }

    public function actions()
    {
        return [
            'upload-avatar' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new Person(), 'avatar'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-avatar' => [
                'class' => RemoveAction::className(),
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Person(),
                'attribute' => 'avatar',
                'upload' => $this->avatarDir
            ]
        ];
    }

    /**
     * Lists all Person models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionList()
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);

        $searchModel = new PersonSearch();
        $searchModel->type = Person::TYPE_DOCTOR;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, null, true);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Person model.
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

    public function actionShow($id)
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);
        $model = $this->findModel($id);

        $now = strtotime(date('Y/m/d 00:00:00', time()));
        $aweek = $now + 7 * 24 * 60 * 60;

        $days = ClinicProgram::find()
            ->innerJoinWith('personsRel')
            ->andWhere(['person_program_rel.personID' => $model->id])
            ->andWhere(['>=', 'date', $now])
            ->andWhere(['<=', 'date', $aweek])
            ->all();

        return $this->render('show', [
            'model' => $model,
            'days' => $days
        ]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Person();

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $avatar = new UploadedFiles($this->tmpDir, $model->avatar, $this->avatarOptions);
            if ($model->save()) {
                $avatar->move($this->avatarDir);
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Person model.
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

        $avatar = new UploadedFiles($this->avatarDir, $model->avatar, $this->avatarOptions);

        if (Yii::$app->request->post()) {
            $oldImage = $model->avatar;
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                $avatar->update($oldImage, $model->avatar, $this->tmpDir);
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['index']);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('update', [
            'model' => $model,
            'avatar' => $avatar,
        ]);
    }

    /**
     * Deletes an existing Person model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $avatar = new UploadedFiles($this->avatarDir, $model->avatar, $this->avatarOptions);
        $avatar->removeAll(true);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('words', 'The requested page does not exist.'));
    }

    public function actionExportCsv()
    {
        $doctors = Person::find()->valid()->all();

        $date = date("Y-m-d-H-i-s");
        $filename = "doctors-$date.csv";
        $file = fopen(Yii::getAlias('@webroot/uploads/temp/') . $filename, "w");

        $line = "نام پزشک,شماره نظام پزشکی";
        fputcsv($file, explode(',', $line));

        foreach ($doctors as $doctor) {
            if (!empty($doctor->medical_number)) {
                $line = "$doctor->name,$doctor->medical_number";
                fputcsv($file, explode(',', $line));
            }
        }
        fclose($file);
        return Yii::$app->response->sendFile(Yii::getAlias('@webroot/uploads/temp/') . $filename, 'doctors.csv')->send();
    }
}
