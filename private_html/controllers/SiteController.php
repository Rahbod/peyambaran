<?php

namespace app\controllers;

use app\components\MainController;
use app\models\Category;
use app\models\Insurance;
use app\models\Message;
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

    public function getMenuActions()
    {
        return [
            'contact',
            'suggestion',
            'complaint',
        ];
    }

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
        $slides = Slide::find()->valid()->orderBy(['id' => SORT_ASC])->all();
        $inpatientInsurances = Insurance::find()->valid()->andWhere(['type' => Insurance::TYPE_INPATIENT])->limit(32)->all();
        $outpatientInsurances = Insurance::find()->valid()->andWhere(['type' => Insurance::TYPE_OUTPATIENT])->limit(32)->all();
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
        return $this->ContactProcess();
    }

    public function actionSuggestion()
    {
        return $this->ContactProcess('suggestion', Message::TYPE_SUGGESTIONS);
    }

    public function actionComplaint()
    {
        return $this->ContactProcess('complaint', Message::TYPE_COMPLAINTS);
    }

    public function ContactProcess($view = 'contact', $type = Message::TYPE_CONTACT_US)
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            $message = new  Message();
            $message->type = $type;
            $message->name = $model->name;
            $message->tel = $model->tel;
            $message->body = $model->body;
            $message->subject = $model->subject;
            $message->email = $model->email;
            $message->department_id = $model->department_id;
            if ($message->save()) {
                $model->contact(Yii::$app->params['adminEmail']);
                Yii::$app->session->setFlash('public-alert', ['type' => 'success', 'message' => Yii::t('words', 'message.successMsg')]);
                return $this->goBack();
            } else
                Yii::$app->session->setFlash('public-alert', ['type' => 'danger', 'message' => Yii::t('words', 'message.dangerMsg')]);
        }

        return $this->render($view, [
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

    /*public function actionTest()
    {
        $insurances = [
            ['name' => 'بيمه تامين اجتماعي'],
            ['name' => 'بيمه سلامت'],
            ['name' => 'بيمه ايران'],
            ['name' => 'بيمه آسيا'],
            ['name' => 'بيمه البرز'],
            ['name' => 'بيمه دانا '],
            ['name' => 'بيمه پارسيان'],
            ['name' => 'بيمه ما'],
            ['name' => 'بيمه ملت'],
            ['name' => 'بيمه نوين '],
            ['name' => 'بيمه تعاون'],
            ['name' => 'بيمه سايپا'],
            ['name' => 'بيمه آتيه سازان حافظ'],
            ['name' => 'بيمه SOS'],
            ['name' => 'بيمه ميهن'],
            ['name' => 'بيمه كارآفرين'],
            ['name' => 'صنايع هواپيمايي'],
            ['name' => 'هواپيمايي آسمان'],
            ['name' => 'شركت هواپيمايي سامان'],
            ['name' => 'شركت نفت فلات قاره'],
            ['name' => 'مجلس شوراي اسلامي'],
            ['name' => 'مركز مشاوره دانشگاه تهران'],
            ['name' => 'بانك مركزي'],
            ['name' => 'بانك ملت'],
            ['name' => 'بانك صادرات'],
            ['name' => 'بانك توسعه صادرات'],
            ['name' => 'بانك تجارت '],
            ['name' => 'بانك رفاه '],
            ['name' => 'بانك مسكن '],
            ['name' => 'بانك سپه '],
            ['name' => 'بانك كشاوري'],
            ['name' => 'بانك صنعت و معدن'],
            ['name' => 'بانك مهر ايران'],
            ['name' => 'صندوق رفاه كيش']
        ];

        $insurances2 = [
            ['name' => 'بيمه تامين اجتماعي'],
            ['name' => 'بيمه سلامت'],
            ['name' => 'بيمه ايران'],
            ['name' => 'بيمه آسيا'],
            ['name' => 'بيمه البرز'],
            ['name' => 'بيمه پارسيان'],
            ['name' => 'بيمه سايپا'],
            ['name' => 'صنايع هواپيمايي'],
            ['name' => 'هواپيمايي آسمان'],
            ['name' => 'شركت سازه گستر سايپا'],
            ['name' => 'مجلس شوراي اسلامي'],
            ['name' => 'بانك مركزي'],
            ['name' => 'بانك ملت'],
            ['name' => 'بانك صادرات'],
            ['name' => 'بانك توسعه صادرات'],
            ['name' => 'بانك تجارت '],
            ['name' => 'بانك رفاه '],
            ['name' => 'بانك مسكن '],
            ['name' => 'بانك سپه '],
            ['name' => 'بانك كشاوري'],
            ['name' => 'بانك صنعت و معدن'],
            ['name' => 'صندوق رفاه كيش']
        ];


        foreach ($insurances as $insurance) {
            $model = new Insurance();
            $model->name = $insurance['name'];
            $model->code = $insurance['code'];
            $model->type = Insurance::TYPE_INPATIENT;
            @$model->save();
        }

        foreach ($insurances2 as $insurance) {
            $model = new Insurance();
            $model->name = $insurance['name'];
            $model->code = $insurance['code'];
            $model->type = Insurance::TYPE_OUTPATIENT;
            @$model->save();
        }
    }*/
}
