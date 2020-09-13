<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Quotations;

/**
 * QuotationsSearch represents the model behind the search form of `app\models\Quotations`.
 */
class QuotationsSearch extends Quotations
{
    public $user;
    public $customer;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'user_id'], 'integer'],
            [['customer', 'user'], 'safe'],
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
        $query = Quotations::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('user');
        $query->joinWith('customer');

        $dataProvider->sort->attributes['user'] = [
            'asc' => [User::tableName().'.id' => SORT_ASC],
            'desc' => [User::tableName().'.id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['customer'] = [
            'asc' => [Customers::tableName().'.id' => SORT_ASC],
            'desc' => [Customers::tableName().'.id' => SORT_DESC],
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

        $query->andFilterWhere(['like', Customers::tableName().'name', $this->customer]);
        $query->andFilterWhere(['like', User::tableName().'user', $this->customer]);


        return $dataProvider;
    }
}
