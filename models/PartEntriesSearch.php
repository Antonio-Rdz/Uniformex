<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PartEntries;

/**
 * PartEntriesSearch represents the model behind the search form about `app\models\PartEntries`.
 */
class PartEntriesSearch extends PartEntries
{
    public $part;
    public $supplier;
    public $warehouse;
    public $user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['part', 'supplier', 'warehouse', 'user'], 'safe'],
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
    public function search($params)
    {
        $query = PartEntries::find();


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $query->joinWith('part');
        $query->joinWith('supplier');
        $query->joinWith('warehouse');
        $query->joinWith('user');

        $dataProvider->sort->attributes['part'] = [
            'asc' => [Parts::tableName().'.name' => SORT_ASC],
            'desc' => [Parts::tableName().'.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['supplier'] = [
            'asc' => [Suppliers::tableName().'.name' => SORT_ASC],
            'desc' => [Suppliers::tableName().'.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['warehouse'] = [
            'asc' => [Warehouses::tableName().'.name' => SORT_ASC],
            'desc' => [Warehouses::tableName().'.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['user'] = [
            'asc' => [User::tableName().'.user' => SORT_ASC],
            'desc' => [User::tableName().'.user' => SORT_DESC],
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
        ]);

        $query->andFilterWhere(['like', Parts::tableName().'.name' , $this->part]);
        $query->andFilterWhere(['like', Suppliers::tableName().'.name' , $this->supplier]);
        $query->andFilterWhere(['like', Warehouses::tableName().'.name' , $this->warehouse]);
        $query->andFilterWhere(['like', User::tableName().'.user' , $this->user]);

        $query->orderBy('timestamp DESC');
        return $dataProvider;
    }
}
