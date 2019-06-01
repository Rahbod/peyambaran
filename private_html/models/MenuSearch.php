<?php

namespace app\models;

use app\components\Helper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Menu;

/**
 * MenuSearch represents the model behind the search form of `app\models\Menu`.
 */
class MenuSearch extends Menu
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parentID', 'status', 'left', 'right', 'depth', 'tree'], 'integer'],
            [['type', 'name', 'dyna', 'extra', 'menu_type'], 'safe'],
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
        $query = Menu::find();

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
            'parentID' => $this->parentID,
            'created' => $this->created,
            'status' => $this->status,
            'left' => $this->left,
            'right' => $this->right,
            'depth' => $this->depth,
            'tree' => $this->tree,
            'type' => $this->type,
            static::columnGetString('menu_type') => $this->menu_type,
        ]);

        $query->andFilterWhere(['REGEXP', 'name', Helper::persian2Arabic($this->name)]);

        $query->orderBy([self::columnGetString('sort') => SORT_ASC]);

        return $dataProvider;
    }
}
