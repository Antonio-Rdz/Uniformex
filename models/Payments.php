<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_ord_payments".
 *
 * @property int $id
 * @property double $amount
 * @property string $paid_date
 * @property int $status_id
 * @property int $order_id
 *
 * @property Orders $order
 */
class Payments extends \yii\db\ActiveRecord
{

    const STATUS = [
        0 => 'En espera',
        1 => 'Retenido',
        2 => 'Acreditado',
        3 => 'Reembolsado',
        4 => 'Cancelado',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_ord_payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'status_id'], 'required'],
            ['order_id', 'required', 'message' => 'Por favor selecciona una orden'],
            [['amount'], 'number'],
            [['paid_date'], 'safe'],
            [['status_id', 'order_id'], 'integer'],
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
            'amount' => 'Monto',
            'paid_date' => 'Fecha de pago',
            'status_id' => 'Estatus',
            'order_id' => 'Orden',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['id' => 'order_id']);
    }
}
