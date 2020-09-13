<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RecordCardsSearch represents the model behind the search form about `app\models\RecordCards`.
 */
class RecordCardsSearch extends RecordCards
{
    public $customer;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['model', 'description', 'thread', 'laundry', 'union', 'over_sewing', 'additional_notes', 'customer'], 'safe'],
            [['width', 'height', 'weight'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
    public function search($params, $product_id = null)
    {
        $query = RecordCards::find();

        if($product_id){
            $query->where([self::tableName().'.product_id' => $product_id]);
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('orderDetails.order.customer');

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
            'width' => $this->width,
            'height' => $this->height,
            'weight' => $this->weight,
        ]);

        $query->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', self::tableName().'.description', $this->description])
            ->andFilterWhere(['like', 'thread', $this->thread])
            ->andFilterWhere(['like', 'laundry', $this->laundry])
            ->andFilterWhere(['like', 'union', $this->union])
            ->andFilterWhere(['like', Customers::tableName().'.name', $this->customer])
            ->andFilterWhere(['like', 'over_sewing', $this->over_sewing])
            ->andFilterWhere(['like', 'additional_notes', $this->additional_notes]);

        return $dataProvider;
    }
}
