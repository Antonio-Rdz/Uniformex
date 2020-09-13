<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LineAssignmentDetails;

/**
 * LineAssignmentDetailsSearch represents the model behind the search form of `app\models\LineAssignmentDetails`.
 */
class LineAssignmentDetailsSearch extends LineAssignmentDetails
{

    public $assignment;
    public $semiCloth;
    public $rawMaterial;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'assignment_id', 'raw_material_id', 'semi_cloth_id'], 'integer'],
            [['quantity'], 'number'],
            [['assignment', 'semiCloth', 'rawMaterial'], 'safe'],
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
    public function search($params, $assignment_id)
    {
        $query = LineAssignmentDetails::find()->where([self::tableName().'.assignment_id' => $assignment_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('assignment');
        $query->joinWith('semiCloth');
        $query->joinWith('rawMaterial');

        $dataProvider->sort->attributes['assignment'] = [
            'asc' => [LineAssignments::tableName().'.id' => SORT_ASC],
            'desc' => [LineAssignments::tableName().'.id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['semiCloth'] = [
            'asc' => [SemiClothes::tableName().'.name' => SORT_ASC],
            'desc' => [SemiClothes::tableName().'.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['rawMaterial'] = [
            'asc' => [RawMaterial::tableName().'.name' => SORT_ASC],
            'desc' => [RawMaterial::tableName().'.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'quantity' => $this->quantity,
        ]);

        $query->andFilterWhere(['like', SemiClothes::tableName().'.name', $this->semiCloth]);

        return $dataProvider;
    }
}
