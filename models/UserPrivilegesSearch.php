<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserPrivileges;

/**
 * UserPrivilegesSearch represents the model behind the search form of `app\models\UserPrivileges`.
 */
class UserPrivilegesSearch extends UserPrivileges
{

    public $user;
    public $privilege;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'privilege_id', 'user_id'], 'integer'],
            [['privilege'], 'string'],
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
    public function search($params, $user_id = null, $privilege_id = null)
    {
        $query = UserPrivileges::find();

        if($user_id){
            $query->where(['user_id' =>  $user_id]);
        }
        if($privilege_id){
            $query->where(['privilege_id' =>  $privilege_id]);
        }

        $query->joinWith('user');
        $query->joinWith('privilege');

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['privilege'] = [
            'asc' => [Privileges::tableName().'.name' => SORT_ASC],
            'desc' => [Privileges::tableName().'.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', Privileges::tableName().'.name', $this->privilege]);
        return $dataProvider;
    }
}
