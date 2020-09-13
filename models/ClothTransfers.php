<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_cloth_transfers".
 *
 * @property int $id
 * @property int $stock_id
 * @property int $original_quantity
 * @property int $on_hold
 * @property int $transferred
 * @property int $status
 * @property int $type
 * @property int $order_id
 *
 * @property Orders $order
 */
class ClothTransfers extends \yii\db\ActiveRecord
{

    const TYPES = [
        1 => 'Apartadas para orden',
    ];

    const STATUSES = [
        0 => 'En espera',
        1 => 'En proceso',
        2 => 'Completado',
        3 => 'Cancelado',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_cloth_transfers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stock_id'], 'required'],
            [['stock_id', 'original_quantity', 'on_hold', 'transferred', 'status', 'type', 'order_id'], 'integer'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stock_id' => 'Stock ID',
            'original_quantity' => 'Cantidad original',
            'on_hold' => 'Retenidas',
            'transferred' => 'Transferidas',
            'status' => 'Estatus',
            'type' => 'Tipo',
            'order_id' => 'Orden',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(ClothesWarehouses::class, ['id' => 'stock_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['id' => 'order_id']);
    }
}
