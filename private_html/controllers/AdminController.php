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
        return ['index', 'login', 'captcha', 'logout'];
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
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->roleID == 'user')
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

        $this->layout = 'login';

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


    public function actionTranslate()
    {
        if (!Yii::$app->request->getQueryParam('lang'))
            return $this->render('translate');

        $baseLang = 'fa';
        $currLang = Yii::$app->request->getQueryParam('lang');
        $baseMessagePath = Yii::getAlias("@app/messages/{$baseLang}/words.php");
        $basePhrases = include $baseMessagePath;
        $destMessagePath = Yii::getAlias("@app/messages/{$currLang}/words.php");
        if (!is_dir(Yii::getAlias("@app/messages/{$currLang}")))
            mkdir(Yii::getAlias("@app/messages/{$currLang}/"), 0755, true);
        if (!is_file($destMessagePath))
            file_put_contents($destMessagePath, "<?php\n\nreturn [];");
        $destPhrases = include $destMessagePath;

        if (Yii::$app->request->post()) {
            $newPhrases = Yii::$app->request->post('new_phrases', []);
            $newContent = "<?php\n\nreturn [";
            foreach ($newPhrases as $key => $newPhrase) {
                if ($currLang == 'en' && $key == $newPhrase)
                    continue;
                if ($newPhrase && $newPhrase != '')
                    $newContent .= "\n  '{$key}' => " . var_export($newPhrase, true) . ",";
            }
            $newContent .= "\n];";
            file_put_contents($destMessagePath, $newContent);
            Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
            return $this->refresh();
        }

        return $this->render('translate', compact('basePhrases', 'destPhrases'));
    }
}
