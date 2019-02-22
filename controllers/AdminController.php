<?php

namespace app\controllers;

use app\models\Page;
use app\models\Slide;
use Yii;
use app\components\AuthController;
use yii\helpers\Url;
use yii\web\Response;
use app\models\LoginForm;

class AdminController extends AuthController
{
    public function getSystemActions()
    {
        return ['index', 'login'];
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
        if(Yii::$app->user->isGuest)
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
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout='login';

        $model = new LoginForm();
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
