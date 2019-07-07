<?php

namespace app\controllers;

use app\components\AuthController;
use app\components\customWidgets\CustomCaptchaAction;
use app\components\SmsSender;
use app\models\LoginForm;
use app\models\UGroup;
use app\models\UserSearch;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use devgroup\dropzone\UploadedFiles;
use Yii;
use app\models\User;
use app\models\Role;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends AuthController
{
    public $avatarPath = 'uploads/users/avatars';

    public function init()
    {
        $this->setTheme('default');
        parent::init();
    }

    /**
     * Returns actions that excluded from user roles
     * @return array
     */
    public function getSystemActions()
    {
        return [
            'upload-image',
            'delete-image',
            'login',
            'logout',
            'register',
            'forgetPassword',
            'changePassword',
            'dashboard',
            'authorize',
            'captcha'
        ];
    }

    /**
     * @inheritdoc
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
            'captcha' => [
                'class' => CustomCaptchaAction::className(),
                'setTheme' => true,
                'width' => 130,
                'height' => 40,
                'transparent' => true,
                'onlyNumber' => true,
                'foreColor' => 0x2040A0,
                'minLength'=>3,
                'maxLength'=>3,
//                'fontFile' => '@webroot/themes/default/assets/vendors/base/fonts/IranSans/ttf/fa-num/IRANSansWeb.ttf'
            ],
            // declares "error" action using a class name
            'upload-image' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new User(), 'image'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-image' => [
                'class' => RemoveAction::className(),
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new User(),
                'attribute' => 'image',
                'upload' => $this->avatarPath
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->setScenario('insert');

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                $auth = Yii::$app->authManager;
                $role = $auth->getRole($model->roleID);
                $auth->assign($role, $model->id);
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        $roles = ArrayHelper::map(Role::validQuery()->all(), 'name', 'description');
        $groups = ArrayHelper::map(UGroup::validQuery()->all(), 'id', 'name');

        return $this->render('create', [
            'model' => $model,
            'roles' => $roles,
            'groups' => $groups,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->groups = ArrayHelper::map($model->ugroups, 'id', 'name');

        $storedFiles = new UploadedFiles($this->avatarPath, $model->image);

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $oldRole = $model->roleID;
            // store model image value in oldImage variable
            $oldImage = $model->image;
            // load post values in model
            $model->load(Yii::$app->request->post());

            if ($model->save()) {
                $storedFiles->update($oldImage, $model->image, $this->tmpDir);

                $auth = Yii::$app->authManager;
                if ($oldRole != $model->roleID) {
                    $auth->revoke($auth->getRole($oldRole), $model->id);
                    $auth->assign($auth->getRole($model->roleID), $model->id);
                }

                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        $roles = ArrayHelper::map(Role::validQuery()->all(), 'name', 'description');
        $groups = ArrayHelper::map(UGroup::validQuery()->all(), 'id', 'name');

        return $this->render('update', [
            'model' => $model,
            'roles' => $roles,
            'groups' => $groups,
            'storedFiles' => $storedFiles
        ]);
    }

    /**
     * Deletes an existing User model.
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->avatar) {
            $avatar = new UploadedFiles($this->avatarPath, $model->avatar);
            $avatar->removeAll(true);
        }
        $model->delete();

        Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.deleteSuccessMsg')]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionChangePassword()
    {
        $model = $this->findModel(Yii::$app->user->id);
        $model->setScenario('change-password');

        if($model->roleID == 'user')
            $this->setTheme('frontend', ['bodyClass' => 'innerPages']);

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                $this->redirect([$model->roleID == 'user'?'/dashboard':'/admin/index']);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);

        }

        return $this->render($model->roleID == 'user'?'user_change_pass':'change_pass', compact('model'));
    }


    public function actionLogin()
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);

        if($return = Yii::$app->request->getQueryParam('return'))
            Yii::$app->session->set('return', $return);

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect([$return?:'/dashboard']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionRegister()
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);

        $model = new User();
        $model->setScenario('register');

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $model->username = $model->phone;
            $model->password = $model->nationalCode;
            $model->roleID = 'user';
            $model->status = 0;
            $model->verification_code = rand(12315, 98879);
            if ($model->save()) {

                //send sms to user
                SmsSender::SendVerification($model->phone, $model->verification_code);

                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                $hash = base64_encode($model->id);
                return $this->redirect(['/user/authorize', 'hash' => urlencode($hash)]);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }


        return $this->render('register', compact('model'));
    }

    public function actionAuthorize()
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);

        if (!Yii::$app->request->isPost && !($hash = urldecode(Yii::$app->request->getQueryParam('hash'))))
            return $this->redirect(['/user/register']);

        $forgetMode = false;
        if (!Yii::$app->request->isPost && Yii::$app->request->getQueryParam('forget') !== null)
            $forgetMode = true;

        if (Yii::$app->request->post()) {
            $code = Yii::$app->request->getBodyParam('code');
            $hash = Yii::$app->request->getBodyParam('hash');
            $forgetMode = Yii::$app->request->getBodyParam('forget');
            $id = base64_decode($hash);
            $model = User::findOne($id);
            if ($model) {
                if ((int)$code === $model->verification_code) {
                    $model->verification_code = null;
                    if ($forgetMode) {
                        $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->nationalCode);
                    } else {
                        $model->status = User::STATUS_ENABLE;
                    }

                    if ($model->save()) {
                        //send sms to user
                        SmsSender::SendAfterSignup($model->phone,$model->username,$model->nationalCode);

                        if($forgetMode)
                            Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'user.recoverySuccessMsg')]);
                        else
                            Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'user.verifySuccessMsg')]);
                        return $this->redirect(['/user/login']);
                    } else
                        Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
                } else
                    Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'user.verification_code_invalid')]);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'user.hash_invalid')]);

        }

        return $this->render('authorize', compact('hash', 'forgetMode'));
    }

    public function actionForgetPassword()
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);

        if (Yii::$app->request->post()) {
            $username = Yii::$app->request->getBodyParam('username');
            $model = User::findByUsername($username);
            if ($model === null) {
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'user.username_invalid')]);
                return $this->refresh();
            }

            $model->verification_code = rand(12315, 98879);
            if ($model->save()) {

                //send sms to user
                SmsSender::SendVerification($model->phone, $model->verification_code);

                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'user.forgetSuccessMsg')]);
                $hash = base64_encode($model->id);
                return $this->redirect(['/user/authorize', 'hash' => urlencode($hash), 'forget' => true]);
            }
        }

        return $this->render('forget_password');
    }

    public function actionDashboard()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->roleID != 'user')
            return $this->redirect(['/']);
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);
        $this->layout = 'dashboard';
        $user = Yii::$app->user->identity;
        return $this->render('dashboard', compact('user'));

    }
}
