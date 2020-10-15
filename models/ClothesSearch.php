<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ClothesSearch represents the model behind the search form of `app\models\Clothes`.
 */
class ClothesSearch extends Clothes
{

    public $stock;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'record_card_id'], 'integer'],
            [['name', 'color'], 'safe'],
            [['average_cost', 'profit_margin'], 'number'],
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
        $query = Clothes::find();

        // add conditions that should always apply here

        $query->joinWith('inventory');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['stock'] = [
            'asc' => [ClothesWarehouses::tableName().'.stock' => SORT_ASC],
            'desc' => [ClothesWarehouses::tableName().'.stock' => SORT_DESC],
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
            'stock' => $this->stock,
            'record_card_id' => $this->record_card_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}
