<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_ord_purchase_orders".
 *
 * @property int $id
 * @property int $order_id
 * @property int $status
 * @property string $requested_date
 * @property string $arrival_date
 * @property string $creation
 * @property int $user_id
 * @property int $supplier_id
 *
 * @property PurchaseOrderDetails[] $details
 * @property Orders $order
 * @property Suppliers $supplier
 * @property User $user
 */
class PurchaseOrders extends \yii\db\ActiveRecord
{

    const STATUSES = [
        1 => 'Por confirmar',
        2 => 'En progreso',
        3 => 'Esperando entrada',
        4 => 'Completada',
        5 => 'Cancelada',
    ];

    const TO_BE_CONFIRMED = 1;
    const IN_PROGRESS = 2;
    const WAITING_ENTRY = 3;
    const COMPLETED = 4;
    const CANCELED = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_ord_purchase_orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'status', 'user_id', 'supplier_id'], 'integer'],
            [['requested_date', 'user_id', 'supplier_id'], 'required'],
            [['requested_date', 'arrival_date', 'creation'], 'safe'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['order_id' => 'id']],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Suppliers::class, 'targetAttribute' => ['supplier_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'status' => 'Estatus',
            'requested_date' => 'Fecha de entrega',
            'arrival_date' => 'Fecha de llegada',
            'creation' => 'Creación',
            'user_id' => 'Usuario',
            'supplier_id' => 'Proveedor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetails()
    {
        return $this->hasMany(PurchaseOrderDetails::class, ['purchase_order_id' => 'id']);
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
    public function getSupplier()
    {
        return $this->hasOne(Suppliers::class, ['id' => 'supplier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
