<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_part_transfers".
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
 * @property PartWarehouses $stock
 */
class PartTransfers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_part_transfers';
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
            [['stock_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartWarehouses::class, 'targetAttribute' => ['stock_id' => 'id']],
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
            'original_quantity' => 'Original Quantity',
            'on_hold' => 'On Hold',
            'transferred' => 'Transferred',
            'status' => 'Status',
            'type' => 'Type',
            'order_id' => 'Order ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(PartWarehouses::class, ['id' => 'stock_id']);
    }
}
