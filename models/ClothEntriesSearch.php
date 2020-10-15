<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ClothEntries;

/**
 * ClothEntriesSearch represents the model behind the search form of `app\models\ClothEntries`.
 */
class ClothEntriesSearch extends ClothEntries
{

    public $warehouse;
    public $cloth;
    public $user;
    public $size;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'warehouse_id', 'cloth_id', 'user_id', 'quantity', 'size'], 'integer'],
            [['timestamp', 'warehouse', 'cloth', 'user'], 'safe'],
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
        $query = ClothEntries::find();
        $query->orderBy('timestamp DESC');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('warehouse');
        $query->joinWith('cloth');
        $query->joinWith('user');
        $query->joinWith('size');

        $dataProvider->sort->attributes['warehouse'] = [
            'asc' => [Warehouses::tableName().'.name' => SORT_ASC],
            'desc' => [Warehouses::tableName().'.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['cloth'] = [
            'asc' => [Clothes::tableName().'.name' => SORT_ASC],
            'desc' => [Clothes::tableName().'.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['user'] = [
            'asc' => [User::tableName().'.user' => SORT_ASC],
            'desc' => [User::tableName().'.user' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['size'] = [
            'asc' => [Sizes::tableName().'.name' => SORT_ASC],
            'desc' => [Sizes::tableName().'.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'timestamp' => $this->timestamp,
            'quantity' => $this->quantity,
        ]);

        $query->andFilterWhere(['like', Warehouses::tableName().'.name', $this->warehouse]);
        $query->andFilterWhere(['like', Clothes::tableName().'.name', $this->cloth]);
        $query->andFilterWhere(['like', User::tableName().'.name', $this->user]);
        $query->andFilterWhere([Sizes::tableName().'.name' => $this->size]);

        return $dataProvider;
    }
}
