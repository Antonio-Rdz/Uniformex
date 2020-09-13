<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "m".
 *
 * @property int $id
 * @property int $product_id
 * @property string $model
 * @property string $description
 * @property double $width
 * @property double $height
 * @property double $weight
 * @property string $thread
 * @property string $laundry
 * @property string $union
 * @property string $over_sewing
 * @property string $additional_notes
 *
 * @property Clothes[] $clothes
 * @property RecordCardComponents[] $components
 * @property RecordCardDesigns[] $designs
 * @property RecordCardParts[] $parts
 * @property Parts $part
 * @property RecordCardPieces[] $pieces
 * @property Products $product
 * @property ClothTypesRecordCards[] $clothTypesRecordCards
 * @property ClothTypes[] $clothTypes
 * @property OrderDetails[] $orderDetails
 */
class RecordCards extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_record_cards';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'model', 'description'], 'required'],
            [['product_id'], 'integer'],
            [['width', 'height', 'weight'], 'number'],
            [['model', 'thread', 'laundry', 'union', 'over_sewing'], 'string', 'max' => 45],
            [['description'], 'string', 'max' => 75],
            [['additional_notes'], 'string', 'max' => 140],
            [['model'], 'unique'],
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
            'width' => 'Anchura (m)',
            'height' => 'Altura (m)',
            'weight' => 'Peso (kg)',
            'model' => 'Modelo',
            'description' => 'Descripción',
            'additional_notes' => 'Observaciones',
            'thread' => 'Hilo',
            'laundry' => 'Lavandería/Planchado',
            'union' => 'Unión',
            'over_sewing' => 'Sobre costura',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClothes()
    {
        return $this->hasMany(Clothes::class, ['record_card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponents()
    {
        return $this->hasMany(RecordCardComponents::class, ['record_card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesigns()
    {
        return $this->hasMany(RecordCardDesigns::class, ['record_card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParts()
    {
        return $this->hasMany(RecordCardParts::class, ['record_card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPart()
    {
        return $this->hasMany(Parts::class, ['id' => 'part_id'])->viaTable('ufmx_inv_record_card_parts', ['record_card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPieces()
    {
        return $this->hasMany(RecordCardPieces::class, ['record_card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClothTypesRecordCards()
    {
        return $this->hasMany(ClothTypesRecordCards::class, ['record_card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClothTypes()
    {
        return $this->hasMany(ClothTypes::class, ['id' => 'cloth_type_id'])->viaTable('ufmx_ord_cloth_types_record_cards', ['record_card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetails::class, ['record_card_id' => 'id']);
    }

    /**
     * @return float|int
     */
    public function getEstimatedPrice(){
        $estimated = 0;
        foreach ($this->components as $component){
            /* @var $component RecordCardComponents */
            $estimated += ($component->material->average_cost * $component->quantity);
        }
        return $estimated <= 0 ? null : $estimated;
    }
}
