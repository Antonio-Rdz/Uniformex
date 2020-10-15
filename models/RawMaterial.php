<?php

namespace app\models;

use yii\db\Query;

/**
 * This is the model class for table "ufmx_inv_raw_material".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property double $cost Last entry’s cost
 * @property double $average_cost
 * @property int $unit_id
 * @property string $color
 *
 * @property MaterialWarehouses[] $materialStock
 * @property Units $unit
 * @property RawMaterialEntries[] $entries
 * @property RecordCardComponents[] $recordCardComponents
 * @property LineAssignmentDetails[] $lineAssignmentDetails
 */
class RawMaterial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_raw_material';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'cost', 'average_cost', 'unit_id'], 'required'],
            [['cost', 'average_cost'], 'number'],
            [['unit_id'], 'integer'],
            [['name', 'color'], 'string', 'max' => 45],
            [['description'], 'string', 'max' => 255],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Units::class, 'targetAttribute' => ['unit_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'description' => 'Descripción',
            'cost' => 'Costo Unitario',
            'average_cost' => 'Costo Promedio',
            'unit_id' => 'Unidad',
            'color' => 'Color',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialStock()
    {
        return $this->hasMany(MaterialWarehouses::class, ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Units::class, ['id' => 'unit_id']);
    }

    /**
     * @return float Quantity of stock in model's unit value
     */
    public function getStock(){
        $q = (new Query())->select(['stock' => 'SUM(stock)'])->from(MaterialWarehouses::tableName())->where(['material_id' => $this->id]);
        return floatval($q->one()['stock']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntries()
    {
        return $this->hasMany(RawMaterialEntries::class, ['raw_material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecordCardComponents()
    {
        return $this->hasMany(RecordCardComponents::class, ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUfmxProdLineAssignmentDetails()
    {
        return $this->hasMany(UfmxProdLineAssignmentDetails::className(), ['raw_material_id' => 'id']);
    }

    /**
     * @param $cloth_id int
     * @return float
     */
    public static function getAverageCost($cloth_id){
        $items = (new Query())->select(['avg_cost' => 'ROUND(AVG(cost), 2)'])
            ->from(RawMaterialEntries::tableName())
            ->where(['raw_material_id' => $cloth_id])
            ->one();
        return (float)$items['avg_cost'];
    }

    /**
     * @inheritDoc
     */
    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if($this->isNewRecord){
            $this->average_cost = $this->cost;
        } else {
            $this->average_cost = self::getAverageCost($this->id);
        }

        return true;
    }

    /**
     * @return array Number of pieces that are not assigned in an assignment
     */
    public function getUnassignedStock(){
        $_finished = LineAssignments::FINISHED; $_canceled = LineAssignments::CANCELED;
        // Get full stock
        $stock = $this->getStock();
        // Get how much of this stock is beign used in other assignments
        $q = (new Query())->select(['quantity' => 'IFNULL(SUM(lad.quantity), 0)'])
            ->from(['lad' => LineAssignmentDetails::tableName()])
            ->innerJoin(['la' => LineAssignments::tableName()], "lad.assignment_id = la.id AND (la.status <> $_finished AND la. status <> $_canceled)")
            ->where(['lad.raw_material_id' => $this->id]);
        $r = $q->one();
        // Return full result
        $quantity = (int)$r['quantity'];
        return [
            "stock" => $stock,
            "assigned" => $quantity,
            "available" => $stock - $quantity,
        ];
    }
}
