<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_clothes_warehouses".
 *
 * @property int $id
 * @property int $cloth_id
 * @property int $warehouse_id
 * @property int $size_id
 * @property int $stock
 *
 * @property Clothes $cloth
 * @property Sizes $size
 * @property Warehouses $warehouse
 */
class ClothesWarehouses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_clothes_warehouses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cloth_id', 'warehouse_id'], 'required'],
            [['cloth_id', 'warehouse_id', 'stock'], 'integer'],
            [['id'], 'unique'],
            [['cloth_id', 'warehouse_id', 'size_id'], 'unique', 'targetAttribute' => ['cloth_id', 'warehouse_id', 'size_id']],
            [['cloth_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clothes::class, 'targetAttribute' => ['cloth_id' => 'id']],
            [['size_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizes::class, 'targetAttribute' => ['size_id' => 'id']],
            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouses::class, 'targetAttribute' => ['warehouse_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cloth_id' => 'Prenda',
            'warehouse_id' => 'Almacén',
            'size_id' => 'Talla',
            'stock' => 'Stock',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCloth()
    {
        return $this->hasOne(Clothes::class, ['id' => 'cloth_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSize()
    {
        return $this->hasOne(Sizes::class, ['id' => 'size_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouses::class, ['id' => 'warehouse_id']);
    }
}
