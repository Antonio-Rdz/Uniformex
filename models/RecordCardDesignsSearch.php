<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RecordCardDesigns;

/**
 * RecordCardsDesignsSearch represents the model behind the search form about `app\models\RecordCardsDesigns`.
 */
class RecordCardDesignsSearch extends RecordCardDesigns
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'record_card_id'], 'integer'],
            [['image', 'location'], 'safe'],
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
    public function search($params, $record_card_id)
    {
        $query = RecordCardDesigns::find()->where(['record_card_id' => $record_card_id]);

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
            'record_card_id' => $this->record_card_id,
        ]);

        $query->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'location', $this->location]);

        return $dataProvider;
    }
}
