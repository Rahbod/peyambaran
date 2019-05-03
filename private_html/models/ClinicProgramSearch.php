<?php

namespace app\models;

use function app\components\dd;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ClinicProgram;

/**
 * ClinicProgramSearch represents the model behind the search form of `app\models\ClinicProgram`.
 */
class ClinicProgramSearch extends ClinicProgram
{
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

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = ClinicProgram::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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

        $query->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'dyna', $this->dyna])
            ->andFilterWhere(['like', 'created', $this->created]);

        $query->orderBy(['date' => SORT_ASC]);

        $query->andWhere(['>=', 'date', strtotime(date('Y/m/d 00:00:00', time()))]);
//        dd(date('Y/m/d 00:00:00', time()));

        return $dataProvider;
    }
}
