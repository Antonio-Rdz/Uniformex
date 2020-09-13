<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_products".
 *
 * @property int $id
 * @property string $model
 * @property string $description
 * @property string $front_image
 * @property string $back_image
 *
 * @property ProductPieces[] $pieces
 * @property OrderDetails[] $orderDetails
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model', 'description', 'front_image', 'back_image'], 'required'],
            [['model'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 75],
            [['front_image', 'back_image'], 'string', 'max' => 120],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Modelo',
            'description' => 'Descripción',
            'front_image' => 'Frente',
            'back_image' => 'Espalda',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPieces()
    {
        return $this->hasMany(ProductPieces::class, ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetails::class, ['product_id' => 'id']);
    }
}
