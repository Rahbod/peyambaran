<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Slide;

/**
 * SlideSearch represents the model behind the search form of `app\models\Slide`.
 */
class SlideSearch extends Slide
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'userID', 'modelID', 'status'], 'integer'],
            [['type'], 'number'],
            [['name', 'dyna', 'extra', 'created','en_status','ar_status'], 'safe'],
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
        $query = Slide::find();

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
            'userID' => $this->userID,
            'modelID' => $this->modelID,
            'type' => $this->type,
            'status' => $this->status,
            self::columnGetString('en_status', 'item', 'INTEGER') => $this->en_status,
            self::columnGetString('ar_status', 'item', 'INTEGER') => $this->ar_status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'dyna', $this->dyna])
            ->andFilterWhere(['like', 'extra', $this->extra])
            ->andFilterWhere(['like', 'created', $this->created]);

        return $dataProvider;
    }
}
