<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserRolesSearch represents the model behind the search form of `app\models\UserRoles`.
 */
class UserRolesSearch extends UserRoles
{

    public $role_name;
    public $role_common_name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'role_id'], 'integer'],
            [['role_name', 'role_common_name'], 'safe'],
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
    public function search($params, $user_id)
    {
        $query = UserRoles::find()->where(['user_id' => $user_id]);

        // add conditions that should always apply here

        $query->joinWith('role');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['role_name'] = [
            'asc' => [Roles::tableName().'.name' => SORT_ASC],
            'desc' => [Roles::tableName().'.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['role_common_name'] = [
            'asc' => [Roles::tableName().'.common_name' => SORT_ASC],
            'desc' => [Roles::tableName().'.common_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', Roles::tableName().'.name', $this->role_name]);
        $query->andFilterWhere(['like', Roles::tableName().'.common_name', $this->role_common_name]);


        return $dataProvider;
    }
}
