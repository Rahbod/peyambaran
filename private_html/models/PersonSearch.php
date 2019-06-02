<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Person;

/**
 * PersonQuery represents the model behind the search form of `app\models\Person`.
 */
class PersonSearch extends Person
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'userID', 'modelID', 'status'], 'integer'],
            [['type'], 'number'],
            [['name', 'dyna', 'extra', 'created', 'medical_number', 'expertise','en_status','ar_status'], 'safe'],
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
     * @param $ids
     * @param bool $valid
     * @return ActiveDataProvider
     */
    public function search($params, $ids = null,$valid = false)
    {
        $query = Person::find();
        if($valid)
            $query->valid();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $this->load($params);

        if($expertiseID = \Yii::$app->request->getQueryParam('expertise'))
            $this->expertise = $expertiseID;

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
            self::columnGetString('expertise') => $this->expertise,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'dyna', $this->dyna])
            ->andFilterWhere(['like', 'extra', $this->extra])
            ->andFilterWhere(['like', static::columnGetString('medical_number'), $this->medical_number])
            ->andFilterWhere(['like', 'created', $this->created]);

        if($ids !== null)
            $query->andWhere(['IN', 'id', $ids]);

        $query->orderBy([static::columnGetString('priority') => SORT_DESC]);

        if(\Yii::$app->language == 'fa')
            $query->addOrderBy(['name' => SORT_ASC]);
        else
            $query->addOrderBy([static::columnGetString(\Yii::$app->language.'_name') => SORT_ASC]);

        if(isset($_GET['debug'])){
            \app\components\dd($query->createCommand()->sql);
        }

        return $dataProvider;
    }
}
