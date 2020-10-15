<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_warehouses".
 *
 * @property int $id
 * @property string $name
 * @property string $street
 * @property string $number
 * @property string $section
 * @property int $state_id
 * @property int $city_id
 * @property int $zip_code
 *
 * @property MaterialWarehouses[] $materialWarehouses
 * @property Cities $city
 * @property States $state
 */
class Warehouses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_warehouses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state_id', 'city_id'], 'required'],
            [['state_id', 'city_id', 'zip_code'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['street', 'section'], 'string', 'max' => 60],
            [['number'], 'string', 'max' => 5],
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
            'name' => 'Name',
            'street' => 'Street',
            'number' => 'Number',
            'section' => 'Section',
            'state_id' => 'State ID',
            'city_id' => 'City ID',
            'zip_code' => 'Zip Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUfmxInvMaterialWarehouses()
    {
        return $this->hasMany(MaterialWarehouses::class, ['warehouse_id' => 'id']);
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
}
