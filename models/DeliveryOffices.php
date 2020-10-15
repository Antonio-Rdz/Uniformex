<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_ord_delivery_offices".
 *
 * @property int $id
 * @property string $name
 *
 * @property Shipments[] $ufmxOrdShipments
 */
class DeliveryOffices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_ord_delivery_offices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShipments()
    {
        return $this->hasMany(Shipments::className(), ['delivery_office_id' => 'id']);
    }
}
