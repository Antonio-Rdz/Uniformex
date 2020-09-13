<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_ord_purchase_order_details".
 *
 * @property int $id
 * @property int $purchase_order_id
 * @property string $description
 * @property double $estimated_cost
 * @property double $real_cost
 * @property int $unit_id
 * @property double $quantity
 * @property int $part_entry_id
 * @property int $material_entry_id
 * @property int $cloth_entry_id
 *
 * @property PurchaseOrders $order
 * @property ClothEntries $clothEntry
 * @property PartEntries $partEntry
 * @property RawMaterialEntries $materialEntry
 * @property Units $unit
 */
class PurchaseOrderDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_ord_purchase_order_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['purchase_order_id', 'unit_id', 'quantity', 'description'], 'required'],
            [['purchase_order_id', 'unit_id', 'part_entry_id', 'material_entry_id', 'cloth_entry_id'], 'integer'],
            [['estimated_cost', 'real_cost', 'quantity'], 'number'],
            [['description'], 'string', 'max' => 60],
            [['purchase_order_id'], 'exist', 'skipOnError' => true, 'targetClass' => PurchaseOrders::class, 'targetAttribute' => ['purchase_order_id' => 'id']],
            [['cloth_entry_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClothEntries::class, 'targetAttribute' => ['cloth_entry_id' => 'id']],
            [['part_entry_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartEntries::class, 'targetAttribute' => ['part_entry_id' => 'id']],
            [['material_entry_id'], 'exist', 'skipOnError' => true, 'targetClass' => RawMaterialEntries::class, 'targetAttribute' => ['material_entry_id' => 'id']],
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
            'purchase_order_id' => 'Orden de compra',
            'description' => 'Descripción',
            'estimated_cost' => 'Costo estimado',
            'real_cost' => 'Costo real',
            'unit_id' => 'Unidad',
            'quantity' => 'Cantidad',
            'part_entry_id' => 'Entrada (avío)',
            'material_entry_id' => 'Entrada (material)',
            'cloth_entry_id' => 'Entrada (prenda)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(PurchaseOrders::class, ['id' => 'purchase_order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClothEntry()
    {
        return $this->hasOne(ClothEntries::class, ['id' => 'cloth_entry_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartEntry()
    {
        return $this->hasOne(PartEntries::class, ['id' => 'part_entry_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialEntry()
    {
        return $this->hasOne(RawMaterialEntries::class, ['id' => 'material_entry_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Units::class, ['id' => 'unit_id']);
    }
}
