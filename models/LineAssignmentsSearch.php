<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LineAssignmentsSearch represents the model behind the search form of `app\models\LineAssignments`.
 */
class LineAssignmentsSearch extends LineAssignments
{
    public $orderDetail;
    public $productionLine;
    public $order;
    public $user;

        /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_detail_id', 'production_line_id', 'status'], 'integer'],
            [['orderDetail', 'order'], 'safe'],
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
    public function search($params, $order_id = null)
    {
        $query = LineAssignments::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('orderDetail');
        $query->joinWith('productionLine');

        if($order_id){
            $query->where(['order_id' => $order_id]);
        }

        $dataProvider->sort->attributes['orderDetail'] = [
            'asc' => [OrderDetails::tableName().'.description' => SORT_ASC],
            'desc' => [OrderDetails::tableName().'.description' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['productionLine'] = [
            'asc' => [ProductionLines::tableName().'.id' => SORT_ASC],
            'desc' => [ProductionLines::tableName().'.id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['order'] = [
            'asc' => [Orders::tableName().'.id' => SORT_ASC],
            'desc' => [Orders::tableName().'.id' => SORT_DESC],
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
            'order_detail_id' => $this->order_detail_id,
            'status' => $this->status,
            'production_line_id' => $this->production_line_id,
        ]);

        $query->andFilterWhere(['like', 'assigned_timestamp', $this->assigned_timestamp]);
        $query->andFilterWhere(['like', OrderDetails::tableName().'.description', $this->orderDetail]);
        $query->andFilterWhere(['like', 'orders.order_number', $this->order]);

        return $dataProvider;
    }
}
