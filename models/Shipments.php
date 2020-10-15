<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_ord_shipments".
 *
 * @property int $id
 * @property int $order_id
 * @property int $delivery_office_id
 * @property double $cost
 * @property string $delivered_date
 *
 * @property DeliveryOffices $deliveryOffice
 * @property Orders $order
 */
class Shipments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_ord_shipments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delivery_office_id', 'cost'], 'required'],
            [['order_id', 'delivery_office_id'], 'integer'],
            [['order_id'], 'required', 'message' => 'Por favor selecciona una orden'],
            [['cost'], 'number'],
            [['delivered_date'], 'string', 'max' => 45],
            [['delivery_office_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveryOffices::class, 'targetAttribute' => ['delivery_office_id' => 'id']],
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
            'order_id' => 'Orden',
            'delivery_office_id' => 'Paquetería',
            'cost' => 'Costo',
            'delivered_date' => 'Entregado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryOffice()
    {
        return $this->hasOne(DeliveryOffices::class, ['id' => 'delivery_office_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['id' => 'order_id']);
    }
}
