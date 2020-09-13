<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orders;

/**
 * OrdersSearch represents the model behind the search form of `app\models\Orders`.
 */
class OrdersSearch extends Orders
{
    public $customer;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'customer_id'], 'integer'],
            [['order_number', 'payment_due_date', 'customer'], 'safe'],
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
        $query = Orders::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('customer');

        $dataProvider->sort->attributes['customer'] = [
            'asc' => [Customers::tableName().'.name' => SORT_ASC],
            'desc' => [Customers::tableName().'.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'payment_due_date' => $this->payment_due_date,
        ]);

        $query->andFilterWhere(['like', 'order_number', $this->order_number]);
        $query->andFilterWhere(['like', Customers::tableName().'.name', $this->customer]);
        $query->orderBy(['creation_timestamp' => SORT_DESC]);

        return $dataProvider;
    }
}
