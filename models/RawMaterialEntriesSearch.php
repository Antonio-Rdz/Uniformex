<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RawMaterialEntriesSearch represents the model behind the search form of `app\models\RawMaterialEntries`.
 */
class RawMaterialEntriesSearch extends RawMaterialEntries
{

    public $warehouse;
    public $rawMaterial;
    public $user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['warehouse', 'rawMaterial', 'user'], 'safe'],
            [['quantity'], 'number'],
            [['timestamp'], 'date']
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
        $query = RawMaterialEntries::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('warehouse');
        $query->joinWith('rawMaterial');
        $query->joinWith('user');

        $dataProvider->sort->attributes['warehouse'] = [
            'asc' => [Warehouses::tableName().'.name' => SORT_ASC],
            'desc' => [Warehouses::tableName().'.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['rawMaterial'] = [
            'asc' => [RawMaterial::tableName().'.name' => SORT_ASC],
            'desc' => [RawMaterial::tableName().'.name' => SORT_DESC],
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
            'timestamp' => $this->timestamp,
            'quantity' => $this->quantity,
        ]);

        $query->andFilterWhere(['like', Warehouses::tableName().'name', $this->warehouse]);
        $query->andFilterWhere(['like', RawMaterial::tableName().'name', $this->rawMaterial]);
        $query->andFilterWhere(['like', User::tableName().'name', $this->user]);

        $query->orderBy('timestamp DESC');

        return $dataProvider;
    }
}
