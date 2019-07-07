<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Gallery;

/**
 * GallerySearch represents the model behind the search form of `app\models\Gallery`.
 */
class GallerySearch extends Gallery
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'userID', 'modelID', 'status'], 'integer'],
            [['type'], 'number'],
            [['catID'], 'number'],
            [['name', 'dyna', 'extra', 'created', 'status'], 'safe'],
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
        $query = Gallery::find();

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
            'item.type' => $this->type,
            'status' => $this->status,
        ]);

        if($this->catID){
            $query->innerJoinWith('catitems')
                ->andWhere(['catitem.catID' => $this->catID]);
        }

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
