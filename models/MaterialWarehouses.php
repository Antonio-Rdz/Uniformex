<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_material_warehouses".
 *
 * @property int $id
 * @property int $warehouse_id
 * @property int $material_id
 * @property int $stock
 *
 * @property Warehouses $warehouse
 * @property RawMaterial $material
 */
class MaterialWarehouses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_material_warehouses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['warehouse_id', 'material_id'], 'required'],
            [['warehouse_id', 'material_id'], 'integer'],
            [['stock'], 'number'],
            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouses::class, 'targetAttribute' => ['warehouse_id' => 'id']],
            [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => RawMaterial::class, 'targetAttribute' => ['material_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'warehouse_id' => 'Warehouse ID',
            'material_id' => 'Material ID',
            'stock' => 'Stock',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouses::class, ['id' => 'warehouse_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(RawMaterial::class, ['id' => 'material_id']);
    }
}
