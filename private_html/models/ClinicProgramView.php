<?php

namespace app\models;

use function app\components\dd;
use app\components\Helper;
use Yii;
use app\components\CustomActiveRecord;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "clinic_program_view".
 *
 * @property string $id
 * @property string $personID
 * @property string $exp
 * @property string $expID
 * @property string $name
 * @property string $en_name
 * @property string $ar_name
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @property string $alternative_personID
 * @property string $description
 */
class ClinicProgramView extends CustomActiveRecord
{
    public $week = null;
    public $fromtime = null;
    public $totime = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clinic_program_view';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'fromtime', 'totime'], 'string'],
            [['exp', 'week'], 'integer'],
            [['exp'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
//    public function scenarios()
//    {
//        // bypass scenarios() implementation in the parent class
//        return Model::scenarios();
//    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'exp' => Yii::t('words', 'Expertise'),
            'name' => Yii::t('words', 'Specialist Doctor'),
            'date' => Yii::t('words', 'Date'),
            'start_time' => Yii::t('words', 'Start Time'),
            'end_time' => Yii::t('words', 'End Time'),
            'description' => Yii::t('words', 'Description'),
            'alternative_personID' => Yii::t('words', 'Alternative Person ID'),
        ]);
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['date' => SORT_ASC],
                'attributes' => [
                    'date' => [
                        'asc' => ['date' => SORT_ASC],
                        'desc' => ['date' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => Yii::t("words", 'Date'),
                    ],
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        //
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'expID' => $this->exp
        ]);

        if (Yii::$app->language == 'fa')
            $query->andFilterWhere(['REGEXP', 'name', Helper::persian2Arabic($this->name)]);
        else
            $query->andFilterWhere(['REGEXP', Yii::$app->language . '_name', Helper::persian2Arabic($this->name)]);

        if ($this->week) {
            $week = $this->week < 3 ? $this->week + 4 : $this->week - 3;
            $query->andWhere("WEEKDAY(DATE_FORMAT(FROM_UNIXTIME(`date`),'%Y-%m-%d')) = :week", [':week' => $week]);
        }

        if ($this->fromtime) {
            $this->fromtime = strpos($this->fromtime, ':') === false ? "$this->fromtime:00" : $this->fromtime;
            $this->fromtime = strpos($this->fromtime, ':') === 1 ? "0$this->fromtime" : $this->fromtime;
            $this->fromtime = Helper::strToTime(str_replace(':', '', $this->fromtime));
            $query->andWhere("TIME_FORMAT(`start_time`, '%H:%i') >= :stime", [':stime' => $this->fromtime]);
        }

        if ($this->totime) {
            $this->totime = strpos($this->totime, ':') === false ? "$this->totime:00" : $this->totime;
            $this->totime = strpos($this->totime, ':') === 1 ? "0$this->totime" : $this->totime;
            $this->totime = Helper::strToTime(str_replace(':', '', $this->totime));
            $query->andWhere("TIME_FORMAT(`end_time`, '%H:%i') <= :etime", [':etime' => $this->totime]);
        }

        $today = strtotime(date('Y/m/d 00:00:00', time()));
        $endweek = $today + 8 * 24 * 60 * 60;
        $query->andWhere(['>=', 'date', $today]);
        $query->andWhere(['<=', 'date', $endweek]);

        return $dataProvider;
    }

    public function getTime()
    {
        return substr($this->start_time, 0, 5) . ' - ' . substr($this->end_time, 0, 5);
    }

    public function getAlternativePerson()
    {
        return $this->hasOne(Item::className(), ['id' => 'alternative_personID']);
    }

    public static function getDayNames()
    {
        $days = array(
            1 => Yii::t('words', 'Saturday'),
            2 => Yii::t('words', 'Sunday'),
            3 => Yii::t('words', 'Monday'),
            4 => Yii::t('words', 'Tuesday'),
            5 => Yii::t('words', 'Wednesday'),
            6 => Yii::t('words', 'Thursday'),
            7 => Yii::t('words', 'Friday'),
        );
        return $days;
    }

    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'personID']);
    }

    public function getExpertise()
    {
        return $this->hasOne(Category::className(), ['id' => 'expID']);
    }
}
