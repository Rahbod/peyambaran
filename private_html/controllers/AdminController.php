<?php

namespace app\controllers;

use app\components\customWidgets\CustomCaptchaAction;
use Yii;
use app\components\AuthController;
use yii\web\Response;
use app\models\LoginForm;

class AdminController extends AuthController
{
    public function getSystemActions()
    {
        return ['index', 'login', 'captcha'];
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => CustomCaptchaAction::className(),
                'width' => 130,
                'height' => 40,
            ]
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

    public function actionIndex()
    {
        if(Yii::$app->user->isGuest || Yii::$app->user->identity->roleID == 'user')
            return $this->redirect(['login']);

        return $this->render('index');
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->roleID != 'user') {
            return $this->goHome();
        }

        $this->layout='login';

        $model = new LoginForm();
        $model->setScenario('admin');
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/admin']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
