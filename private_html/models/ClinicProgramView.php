<?php

namespace app\models;

use Yii;
use app\components\CustomActiveRecord;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "clinic_program_view".
 *
 * @property string $id
 * @property string $exp
 * @property string $name
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @property string $description
 */
class ClinicProgramView extends CustomActiveRecord
{
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
            [['id'], 'integer'],
            [['date', 'dyna', 'created'], 'safe'],
        ];
    }
//
//    /**
//     * {@inheritdoc}
//     */
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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andWhere(['>=', 'date', strtotime(date('Y/m/d 00:00:00', time()))]);

        return $dataProvider;
    }

    public function getTime()
    {
        return substr($this->start_time,0,5) .' - '. substr($this->end_time,0,5);
    }
}
