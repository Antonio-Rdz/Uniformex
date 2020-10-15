<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RawMaterialSearch represents the model behind the search form of `app\models\RawMaterial`.
 */
class RawMaterialSearch extends RawMaterial
{

    public $unit;
    public $stock;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'unit_id'], 'integer'],
            [['name', 'description', 'color', 'unit', 'stock'], 'safe'],
            [['cost'], 'number'],
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
        $query = RawMaterial::find();

        // add conditions that should always apply here
        $query->joinWith('unit');
        $query->joinWith('materialStock');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['unit'] = [
            'asc' => [Units::tableName().'.name' => SORT_ASC],
            'desc' => [Units::tableName().'.name' => SORT_DESC],
        ];

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
            'cost' => $this->cost,
            'stock' => $this->stock
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', Units::tableName().'.name', $this->unit]);

        return $dataProvider;
    }
}
