<?php

namespace app\controllers;

use function app\components\dd;
use app\components\MainController;
use app\models\Category;
use app\models\Insurance;
use app\models\OnlineService;
use app\models\Post;
use app\models\Slide;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ContactForm;

class SiteController extends MainController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

//    public function actionError()
//    {
//        var_dump(Yii::$app->request);exit;
//    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->db->createCommand("ALTER TABLE `category` 
MODIFY COLUMN `type`  enum('cat','tag','lst','mnu','dep') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `parentID`;")->execute();

        $slides = Slide::find()->valid()->all();
        $inpatientInsurances = Insurance::find()->valid()->andWhere(['type' => Insurance::TYPE_INPATIENT])->all();
        $outpatientInsurances = Insurance::find()->valid()->andWhere(['type' => Insurance::TYPE_OUTPATIENT])->all();
        $posts = Post::find()->valid()->andWhere(['<=', Post::columnGetString('publish_date'), time()])->all();
        $galleryCategories = Category::find()->valid()->andWhere(['type' => Category::TYPE_CATEGORY, Category::columnGetString('category_type') => Category::CATEGORY_TYPE_PICTURE_GALLERY])->all();
        $onlineServices = OnlineService::find()->valid()->all();

        return $this->render('index', compact('slides', 'inpatientInsurances', 'outpatientInsurances', 'posts', 'galleryCategories', 'onlineServices'));
    }

    public function actionChangeLang($language = false, $controller = false, $action = false)
    {
        if ($language) {
            Yii::$app->language = $language;
            Yii::$app->session->set('language', $language);
            $cookie = new \yii\web\Cookie([
                'name' => 'language',
                'value' => $language,
            ]);
            $cookie->expire = time() + (60 * 60 * 24 * 365); // (1 year)
            Yii::$app->response->cookies->add($cookie);
        }

        $referrer = Yii::$app->request->getReferrer() ?: ['/'];
        if (!$controller)
            return $this->redirect($referrer);

        $url = str_replace(["/$language", "$language/"], "", $referrer);
        return $this->redirect($url);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSearch()
    {
        $term = Yii::$app->request->getQueryParam('term');
        if ($term && !empty($term)) {
            return $this->render('search', compact('term'));
        } else
            return $this->goBack();
    }
}
