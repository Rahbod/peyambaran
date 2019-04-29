<?php

namespace app\controllers;

use function app\components\dd;
use app\components\Helper;
use app\models\ClinicProgramView;
use app\models\Person;
use app\models\PersonProgramRel;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use devgroup\dropzone\UploadedFiles;
use moonland\phpexcel\Excel;
use ruskid\csvimporter\CSVImporter;
use ruskid\csvimporter\CSVReader;
use Yii;
use app\models\ClinicProgram;
use app\models\ClinicProgramSearch;
use app\components\AuthController;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ClinicController implements the CRUD actions for ClinicProgram model.
 */
class ClinicController extends AuthController
{
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
            'show'
        ];
    }

    public function getSystemActions()
    {
        return [
            'upload-csv',
            'delete-csv',
            'upload-excel',
            'delete-excel',
            'show'
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
            'upload-csv' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new ClinicProgram(), 'csv_file'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('csv')
                )
            ],
            'delete-csv' => [
                'class' => RemoveAction::className(),
            ],
            'upload-excel' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new ClinicProgram(), 'excel_file'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('xlsx', 'xls')
                )
            ],
            'delete-excel' => [
                'class' => RemoveAction::className(),
            ],
        ];
    }

    /**
     * Lists all ClinicProgram models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClinicProgramSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionShow()
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);

        $clinicSearchModel = new ClinicProgramView();
        $dataProvider = $clinicSearchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        return $this->render('show', compact('clinicSearchModel', 'dataProvider'));
    }

    /**
     * Displays a single ClinicProgram model.
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
     * Creates a new ClinicProgram model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ClinicProgram();
        if ($copy = Yii::$app->request->getQueryParam('copy')) {
            $copyModel = ClinicProgram::findOne($copy);
            $model = clone $copyModel;
            $model->isNewRecord = true;
            $model->id = null;
            $model->created = (string)time();
        }

        $model->date = $model->getLastDay();

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect($copy ? ['update', 'id' => $model->id] : ['create']);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ClinicProgram model.
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
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->refresh();
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ClinicProgram model.
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
     * Finds the ClinicProgram model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClinicProgram the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClinicProgram::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('words', 'The requested page does not exist.'));
    }

    public function actionAddDoctor()
    {
        $model = new PersonProgramRel();
        $model->load(Yii::$app->request->post());

        $dayID = $model->dayID;
        if (!$dayID) {
            $cmodel = new ClinicProgram();
            $cmodel->date = $cmodel->getLastDay();
            $cmodel->is_holiday = 0;
            if ($cmodel->save())
                $model->dayID = $cmodel->id;
            else {
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
                return $this->redirect(['create']);
            }
        }

        if ($model->save())
            Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
        else
            Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);

        return $this->redirect(['update', 'id' => $model->dayID]);
    }

    public function actionImportCsvProgram()
    {
        $model = new ClinicProgram();

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $date = $model->date;
            $model->date = Helper::jDateTotoGregorian($model->date);
            $model->is_holiday = 0;


            $file = new UploadedFiles($this->tmpDir, $model->csv_file);

            // process csv file
            $importer = new CSVImporter();
            $importer->setData(new CSVReader([
                'filename' => Yii::getAlias("@webroot/$this->tmpDir/$model->csv_file"),
                'fgetcsvOptions' => [
                    'delimiter' => ','
                ]
            ]));

            $notDefined = [];
            $rows = $importer->getData();
            foreach ($rows as $key => $data) {
                /** @var $person Person */
                $medical_number = $data[0];
                $person = Person::find()->valid()->andWhere([Person::columnGetString('medical_number') => $medical_number])->one();
                if (!$person) {
                    $notDefined[] = $medical_number;
                    continue;
                }

                $st = Helper::strToTime($data[1]);
                $et = Helper::strToTime($data[2]);
                $status = $data[3];
                $description = !empty($data[4]) ? "$status $data[4]" : $status;

                $model->doctors[] = [
                    'personID' => $person->id,
                    'start_time' => $st,
                    'end_time' => $et,
                    'description' => $description,
                    'alternative_personID' => null // alternative doctor
                ];
            }

            if ($notDefined)
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => "شماره نظام پزشکی های زیر تعریف نشده اند:\n" . implode("\n", $notDefined)]);
            else {
                if ($model->save()) {
                    $file->removeAll(true);
                    Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                    return $this->redirect(['update', 'id' => $model->id]);
                } else
                    Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
            }

            $model->date = $date;
        }

        return $this->render('csv_import', compact('model', 'file'));
    }

    public function actionImportExcelProgram()
    {
        $model = new ClinicProgram();

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $date = $model->date;
            $model->date = Helper::jDateTotoGregorian($model->date);
            $model->is_holiday = 0;


            $file = new UploadedFiles($this->tmpDir, $model->excel_file);

            // process excel file
            $rows = (array)Excel::import(Yii::getAlias("@webroot/$this->tmpDir/$model->excel_file"), [
                'setFirstRecordAsKeys' => false,
            ]);
            $keys = $rows[1];
            unset($rows[1]);

            $notDefined = [];
            foreach ($rows as $key => $data) {
                /** @var $person Person */
                $medical_number = $data['A'];
                $person = Person::find()->valid()->andWhere([Person::columnGetString('medical_number') => $medical_number])->one();
                if (!$person) {
                    $notDefined[] = $medical_number;
                    continue;
                }

                $st = Helper::strToTime($data['B']);
                $et = Helper::strToTime($data['C']);
                $status = $data['D'];
                $description = !empty($data['E']) ? "$status {$data['E']}" : $status;

                $model->doctors[] = [
                    'personID' => $person->id,
                    'start_time' => $st,
                    'end_time' => $et,
                    'description' => trim($description),
                    'alternative_personID' => null // alternative doctor
                ];
            }

            if ($notDefined)
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => "شماره نظام پزشکی های زیر تعریف نشده اند:\n" . implode("\n", $notDefined)]);
            else {
                if ($model->save()) {
                    $file->removeAll(true);
                    Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                    return $this->redirect(['update', 'id' => $model->id]);
                } else
                    Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
            }

            $model->date = $date;
        }

        return $this->render('excel_import', compact('model', 'file'));
    }
}
