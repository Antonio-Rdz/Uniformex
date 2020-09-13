<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CustomerAddresses;

/**
 * CustomerAddressesSearch represents the model behind the search form of `app\models\CustomerAddresses`.
 */
class CustomerAddressesSearch extends CustomerAddresses
{

    public $city;
    public $state;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'city_id', 'state_id'], 'integer'],
            [['alias', 'street', 'number', 'section', 'country', 'zip_code', 'city', 'state'], 'safe'],
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
    public function search($params, $customer_id)
    {
        $query = CustomerAddresses::find()->where(['customer_id' => $customer_id]);

        // add conditions that should always apply here

        $query->joinWith('state');
        $query->joinWith('city');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['city'] = [
            'asc' => [Cities::tableName().'.name' => SORT_ASC],
            'desc' => [Cities::tableName().'.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['state'] = [
            'asc' => [States::tableName().'.name' => SORT_ASC],
            'desc' => [States::tableName().'.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'section', $this->section])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', Cities::tableName().'.name', $this->city])
            ->andFilterWhere(['like', States::tableName().'.name', $this->state])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code]);

        return $dataProvider;
    }
}
