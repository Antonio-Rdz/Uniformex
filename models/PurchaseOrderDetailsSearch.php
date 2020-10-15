<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PurchaseOrderDetails;

/**
 * PurchaseOrderDetailsSearch represents the model behind the search form about `app\models\PurchaseOrderDetails`.
 */
class PurchaseOrderDetailsSearch extends PurchaseOrderDetails
{

    public $unit;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'purchase_order_id', 'unit_id', 'quantity', 'part_entry_id', 'material_entry_id', 'cloth_entry_id'], 'integer'],
            [['description', 'unit'], 'safe'],
            [['estimated_cost', 'real_cost'], 'number'],
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
    public function search($params, $puchase_order_id)
    {
        $query = PurchaseOrderDetails::find()->where(['purchase_order_id' => $puchase_order_id]);

        // add conditions that should always apply here

        $query->joinWith('unit');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['unit'] = [
            'asc' => [Units::tableName().'.name' => SORT_ASC],
            'desc' => [Units::tableName().'.name' => SORT_DESC],
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
            'purchase_order_id' => $this->purchase_order_id,
            'estimated_cost' => $this->estimated_cost,
            'real_cost' => $this->real_cost,
            'quantity' => $this->quantity,
            'part_entry_id' => $this->part_entry_id,
            'material_entry_id' => $this->material_entry_id,
            'cloth_entry_id' => $this->cloth_entry_id,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere(['like', Units::tableName().'.name', $this->unit]);

        return $dataProvider;
    }
}
