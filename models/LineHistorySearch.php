<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LineHistory;

/**
 * LineHistorySearch represents the model behind the search form of `app\models\LineHistory`.
 */
class LineHistorySearch extends LineHistory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'assignment_id'], 'integer'],
            [['started_timestamp', 'produced_timestamp', 'quantity'], 'safe'],
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
        $query = LineHistory::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'started_timestamp' => $this->started_timestamp,
            'produced_timestamp' => $this->produced_timestamp,
            'assignment_id' => $this->assignment_id,
        ]);

        $query->andFilterWhere(['like', 'quantity', $this->quantity]);

        return $dataProvider;
    }
}
