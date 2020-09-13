<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RolePrivileges;

/**
 * RolePrivilegesSearch represents the model behind the search form of `app\models\RolePrivileges`.
 */
class RolePrivilegesSearch extends RolePrivileges
{

    public $role;
    public $privilege;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'role_id', 'privilege_id'], 'integer'],
            [['privilege'], 'string']
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
    public function search($params, $role_id = null)
    {
        $query = RolePrivileges::find();

        if($role_id){
            $query->where(['role_id' =>  $role_id]);
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('role');
        $query->joinWith('privilege');


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
        $query->andFilterWhere(['like', Privileges::tableName().'.description', $this->privilege]);


        return $dataProvider;
    }
}
