<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_product_pieces".
 *
 * @property int $id
 * @property int $product_id
 * @property int $piece_id
 * @property int $quantity
 *
 * @property Pieces $piece
 * @property Products $product
 */
class ProductPieces extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_product_pieces';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'piece_id', 'quantity'], 'required'],
            [['product_id', 'piece_id', 'quantity'], 'integer'],
            [['product_id', 'piece_id'], 'unique', 'targetAttribute' => ['product_id', 'piece_id'], 'message' => 'Ya has agregado esa pieza al producto '.$this->product->description],
            [['piece_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pieces::class, 'targetAttribute' => ['piece_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Producto',
            'piece_id' => 'Pieza',
            'quantity' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPiece()
    {
        return $this->hasOne(Pieces::class, ['id' => 'piece_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }
}
