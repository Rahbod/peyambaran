<?php

namespace app\controllers;

use function app\components\dd;
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
        $slides = Slide::find()->valid()->all();
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
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            $message = new  Message();
            $message->type = Message::TYPE_CONTACT_US;
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

    /*public function actionTest()
    {
        $insurances = [
            ['name' => 'آزاد', 'code' => '101'],
            ['name' => 'آسيا', 'code' => '102'],
            ['name' => 'البرز', 'code' => '103'],
            ['name' => 'ايران-معرفي نامه', 'code' => '104'],
            ['name' => 'بانك تجارت', 'code' => '105'],
            ['name' => 'بانك ملت', 'code' => '106'],
            ['name' => 'بانك سپه', 'code' => '107'],
            ['name' => 'بانك صادرات', 'code' => '108'],
            ['name' => 'بانك مركزي', 'code' => '109'],
            ['name' => 'بانك كشاورزي', 'code' => '112'],
            ['name' => 'هواپيمايي هما', 'code' => '114'],
            ['name' => 'صداو سيما', 'code' => '117'],
            ['name' => 'شهرداري ', 'code' => '121'],
            ['name' => 'پارسيان (ايران خودرو )', 'code' => '127'],
            ['name' => 'دانا', 'code' => '128'],
            ['name' => 'صنايع هواپيمايي', 'code' => '129'],
            ['name' => 'سينا ', 'code' => '136'],
            ['name' => 'دي ', 'code' => '145'],
            ['name' => 'بيمه سامان', 'code' => '155'],
            ['name' => 'كمك رسان اريا', 'code' => '163'],
            ['name' => 'كاركنان ايران(رايگان)', 'code' => '166'],
            ['name' => 'بيمه پاسارگاد', 'code' => '170'],
            ['name' => 'سلامت كارمندي', 'code' => '182'],
            ['name' => 'البرز(10درصد)', 'code' => '184'],
            ['name' => 'پارس خودرو ', 'code' => '185'],
            ['name' => 'سايپا', 'code' => '186'],
            ['name' => 'شركت پنها', 'code' => '187'],
            ['name' => 'هواپيمايي آسمان ', 'code' => '189'],
            ['name' => 'بيمه SOS', 'code' => '191'],
            ['name' => 'بيمه معلم ', 'code' => '192'],
            ['name' => 'بيمه پارسيان ', 'code' => '193'],
            ['name' => 'خدمات درماني خويش فرما', 'code' => '194'],
            ['name' => 'سلامت سايراقشار', 'code' => '195'],
            ['name' => 'ايران نيرو', 'code' => '196'],
            ['name' => 'نيرو هاي مسلح (جانبازان)', 'code' => '197'],
            ['name' => 'ايران رايگان -دفترچه', 'code' => '198'],
            ['name' => 'البرز(5 درصد)', 'code' => '199'],
            ['name' => 'كارگستران راهبر', 'code' => '200'],
            ['name' => 'پيماني ', 'code' => '201'],
            ['name' => 'دانشگاه علوم پزشكي', 'code' => '202'],
            ['name' => '100%بانك صادرات', 'code' => '204'],
            ['name' => '100% بانك سپه', 'code' => '205'],
            ['name' => 'دانا(كارت طلايي)', 'code' => '206'],
            ['name' => 'صدا و سيما 10%', 'code' => '207'],
            ['name' => 'سينا- شركت آب و فاضلاب', 'code' => '208'],
            ['name' => '100% بانك تجارت', 'code' => '209'],
            ['name' => 'ستاد مبارزه با مواد مخدر', 'code' => '210'],
            ['name' => 'ايران ', 'code' => '211'],
            ['name' => 'آسيا سرپايي', 'code' => '212'],
            ['name' => 'تامين اجتماعي(خاص)', 'code' => '213'],
            ['name' => 'آتيه سازان حافظ', 'code' => '214'],
            ['name' => 'تامين اجتماعي  اجباري', 'code' => '215'],
            ['name' => 'شركت مگا موتور', 'code' => '216'],
            ['name' => 'شهيد شوريده', 'code' => '217'],
            ['name' => 'تامين اجتماعي اختياري', 'code' => '218'],
            ['name' => 'بانك مسكن', 'code' => '219'],
            ['name' => '100%بانك كشاورزي', 'code' => '220'],
            ['name' => 'شركت نفت فلات قاره', 'code' => '222'],
            ['name' => 'بيمه آرمان', 'code' => '223'],
            ['name' => 'سايپا(سي تي اسكن )', 'code' => '225'],
            ['name' => 'آفتاب شرق', 'code' => '226'],
            ['name' => 'سايپا پرس', 'code' => '227'],
            ['name' => 'موُسسه فرهنگي مطبوعاتي ايران', 'code' => '228'],
            ['name' => 'بيمه SOS (سرپايي)', 'code' => '229'],
            ['name' => 'دارالشفاء الكوثر', 'code' => '230'],
            ['name' => 'بيمه ما', 'code' => '231'],
            ['name' => 'مجلس شوراي اسلامي', 'code' => '232'],
            ['name' => 'تامين اجتماعي مستمري بگيران', 'code' => '233'],
            ['name' => 'بيمه ميهن', 'code' => '234'],
            ['name' => 'فداراسيون فوتبال', 'code' => '235'],
            ['name' => 'ارتش (سي تي اسكن )', 'code' => '236'],
            ['name' => 'بانك صنعت و معدن', 'code' => '237'],
            ['name' => 'كتابخانه مجلس شوراي اسلامي', 'code' => '238'],
            ['name' => 'شركت سازه گستر سايپا', 'code' => '239'],
            ['name' => 'رازي ', 'code' => '240'],
            ['name' => 'بيمه ملت ', 'code' => '242'],
            ['name' => 'ايران كاركنان پيماني', 'code' => '243'],
            ['name' => 'پارسيان 20%', 'code' => '244'],
            ['name' => 'سلامت (ايرانيان)', 'code' => '245'],
            ['name' => 'رياست جمهوري (موادمخدر)', 'code' => '246'],
            ['name' => 'شركت فولاد ', 'code' => '247'],
            ['name' => 'خدمات-آسيا-فرهنگيان', 'code' => '248'],
            ['name' => 'هواپيمايي فارسكو', 'code' => '249'],
            ['name' => 'فدراسيون دوچرخه سواري', 'code' => '250'],
            ['name' => 'دانا 100%', 'code' => '252'],
            ['name' => 'ايران (نفتكش)', 'code' => '253'],
            ['name' => 'تامين اجتماعي مشاغل آزاد', 'code' => '255'],
            ['name' => 'صداوسيما(رايگان)', 'code' => '256'],
            ['name' => 'تامين اجتماعي(عادي)', 'code' => '258'],
            ['name' => 'سايپا(مديران)', 'code' => '259'],
            ['name' => 'معلم (سرپايي)', 'code' => '261'],
            ['name' => 'ايران نيرو 100%', 'code' => '262'],
            ['name' => 'سينا (سرپايي)', 'code' => '263'],
            ['name' => 'سينا 10%', 'code' => '265'],
            ['name' => 'بانك توسعه صادرات ', 'code' => '266'],
            ['name' => 'بانك ملي (c.t)', 'code' => '272'],
            ['name' => 'بانك رفاه ', 'code' => '273'],
            ['name' => 'ايران كارت طلايي', 'code' => '274'],
            ['name' => 'صندوق رفاه كيش', 'code' => '275'],
            ['name' => 'صندوق رفاه كيش (داروخانه)', 'code' => '276'],
            ['name' => 'وزارت كشور', 'code' => '277'],
            ['name' => 'پارسيان الكترونيك', 'code' => '282'],
            ['name' => 'تامين اجتماعي مستمري بگير', 'code' => '283'],
            ['name' => 'دياليز', 'code' => '284'],
            ['name' => 'ايران كارت طلايي بنياد', 'code' => '285'],
            ['name' => 'آسيا-وزارت كشور', 'code' => '286'],
            ['name' => 'فرهنگيان', 'code' => '287'],
            ['name' => 'دانا رايگان', 'code' => '288'],
            ['name' => 'هواپيمايي پنها', 'code' => '289'],
            ['name' => 'بنادر وكشتيراني (5%)', 'code' => '290'],
            ['name' => 'بنادر وكشتيراني (10%)', 'code' => '291'],
            ['name' => 'بنادر وكشتيراني (رايگان)', 'code' => '292'],
            ['name' => 'بيمه سلامت (خاص)', 'code' => '293'],
            ['name' => 'شركت زامياد', 'code' => '294'],
            ['name' => 'بيمه كارآفرين', 'code' => '295'],
            ['name' => 'بيمه نوين', 'code' => '296'],
            ['name' => 'بيمه كوثر', 'code' => '297'],
            ['name' => 'بيمارستان', 'code' => '298'],
            ['name' => 'پارسيان 10%', 'code' => '299'],
            ['name' => 'بيمارستان اميد', 'code' => '300'],
            ['name' => 'آتيه سازان (بازنشستگان كشوري)', 'code' => '301'],
            ['name' => 'بيمه حكمت', 'code' => '302'],
            ['name' => 'شركت هواپيمايي سامان', 'code' => '303'],
            ['name' => 'شركت كارگزاري سايپا', 'code' => '304'],
            ['name' => 'بيمه تعاون', 'code' => '305'],
            ['name' => 'بانك قرض الحسنه مهر ايران', 'code' => '306'],
            ['name' => 'آتيه سازان حافظ(شاغلين آموزش و  پرورش)', 'code' => '307'],
            ['name' => 'البرز (مهاب قدس)', 'code' => '308'],
            ['name' => 'مركز مشاوره دانشگاه تهران', 'code' => '309'],
            ['name' => 'بيماران IPD', 'code' => '310']
        ];

        foreach ($insurances as $insurance){
            $model= new Insurance();
            $model->name = $insurance['name'];
            $model->code = $insurance['code'];
            $model->type = Insurance::TYPE_OUTPATIENT;
            @$model->save();
        }

        foreach ($insurances as $insurance){
            $model= new Insurance();
            $model->name = $insurance['name'];
            $model->code = $insurance['code'];
            $model->type = Insurance::TYPE_INPATIENT;
            @$model->save();
        }
    }*/
}
