<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_cxs_customer_addresses".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $alias
 * @property string $street
 * @property string $number
 * @property string $section
 * @property int $city_id
 * @property int $state_id
 * @property string $country
 * @property string $zip_code
 *
 * @property Customers $customer
 * @property Cities $city
 * @property States $state
 * @property Quotations[] $ufmxMiscQuotations
 */
class CustomerAddresses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_cxs_customer_addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'city_id', 'state_id'], 'required'],
            [['customer_id', 'state_id'], 'integer'],
            [['alias', 'street', 'number', 'section', 'country'], 'string', 'max' => 45],
            [['zip_code'], 'string', 'max' => 6],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::class, 'targetAttribute' => ['customer_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['city_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => States::class, 'targetAttribute' => ['state_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Cliente',
            'alias' => 'Alias',
            'street' => 'Calle',
            'number' => 'Número',
            'section' => 'Fraccionamiento',
            'city_id' => 'Ciudad',
            'state_id' => 'Estado',
            'country' => 'País',
            'zip_code' => 'Código Postal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customers::class, ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(States::class, ['id' => 'state_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotations()
    {
        return $this->hasMany(Quotations::class, ['customer_id' => 'id']);
    }
}
