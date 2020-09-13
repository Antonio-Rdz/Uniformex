<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_ord_order_history".
 *
 * @property int $id
 * @property int $order_id
 * @property int $user_id
 * @property string $timestamp
 * @property int $changed_from
 * @property int $changed_to
 *
 * @property Orders $order
 * @property User $user
 */
class OrderHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_ord_order_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'changed_from', 'changed_to'], 'required'],
            [['order_id', 'changed_from', 'changed_to'], 'integer'],
            [['timestamp'], 'safe'],
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
            'user_id' => 'Usuario',
            'timestamp' => 'Marca de tiempo',
            'changed_from' => 'Estatus anterior',
            'changed_to' => 'Nuevo estatus',
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
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
