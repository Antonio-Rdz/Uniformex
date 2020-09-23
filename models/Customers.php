<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "ufmx_cxs_customers".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $register_time
 * @property string $last_updated
 *
 * @property CustomerAddresses[] $addresses
 * @property Orders[] $orders
 */
class Customers extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_cxs_customers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name', 'rfc'], 'required'],
            [['register_time', 'last_updated'], 'safe'],
            [['email'], 'string', 'max' => 45],
            [['name'], 'string', 'max' => 60],
            [['rfc'], 'string', 'max' => 45],
        ]; 
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Nombre',
            'rfc' => 'RFC',
            'register_time' => 'Registro',
            'last_updated' => 'Última Modificación',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(CustomerAddresses::class, ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['customer_id' => 'id']);
    }
}
