<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_misc_cities".
 *
 * @property int $id
 * @property string $name
 * @property int $state_id
 *
 * @property CustomerAddresses[] $ufmxCxsCustomerAddresses
 * @property Warehouses[] $ufmxInvWarehouses
 * @property States $state
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_misc_cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'state_id'], 'required'],
            [['state_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
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
            'name' => 'Name',
            'state_id' => 'State ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUfmxCxsCustomerAddresses()
    {
        return $this->hasMany(CustomerAddresses::class, ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUfmxInvWarehouses()
    {
        return $this->hasMany(Warehouses::class, ['city_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(States::class, ['id' => 'state_id']);
    }
}
