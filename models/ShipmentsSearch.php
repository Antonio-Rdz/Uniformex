<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Shipments;

/**
 * ShipmentsSearch represents the model behind the search form of `app\models\Shipments`.
 */
class ShipmentsSearch extends Shipments
{
    public $deliveryOffice;
    public $order;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'delivery_office_id'], 'integer'],
            [['cost'], 'number'],
            [['delivered_date', 'order', 'deliveryOffice'], 'safe'],
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
        $query = Shipments::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('order');
        $query->joinWith('deliveryOffice');

        $dataProvider->sort->attributes['order'] = [
            'asc' => [Orders::tableName().'.order_number' => SORT_ASC],
            'desc' => [Orders::tableName().'.order_number' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['deliveryOffice'] = [
            'asc' => [DeliveryOffices::tableName().'.name' => SORT_ASC],
            'desc' => [DeliveryOffices::tableName().'.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'delivery_office_id' => $this->delivery_office_id,
            'cost' => $this->cost,
        ]);

        $query->andFilterWhere(['like', 'delivered_date', $this->delivered_date]);

        return $dataProvider;
    }
}
