<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_ord_cloth_types".
 *
 * @property int $id
 * @property string $name
 * @property string $color
 *
 * @property OrderDetails[] $orderDetails
 */
class ClothTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_ord_cloth_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'color'], 'required'],
            [['name'], 'string', 'max' => 65],
            [['color'], 'string', 'max' => 60],
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
            'color' => 'Color',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetails::class, ['cloth_type_id' => 'id']);
    }
}
