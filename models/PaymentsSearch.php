<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PaymentsSearch represents the model behind the search form of `app\models\Payments`.
 */
class PaymentsSearch extends Payments
{
    public $payment;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'order_id'], 'integer'],
            [['amount'], 'number'],
            [['paid_date', 'order'], 'safe'],
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
        $query = Payments::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('order');

        $dataProvider->sort->attributes['order'] = [
            'asc' => [Orders::tableName().'.description' => SORT_ASC],
            'desc' => [Orders::tableName().'.description' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'amount' => $this->amount,
            'paid_date' => $this->paid_date,
            'status_id' => $this->status_id,
            'order_id' => $this->order_id,
        ]);
        $query->andFilterWhere(['like', Orders::tableName().'.order_number', $this->order]);

        return $dataProvider;
    }
}
