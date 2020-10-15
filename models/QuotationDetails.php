<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_misc_quotation_details".
 *
 * @property int $id
 * @property int $quotation_id
 * @property string $description
 * @property string $color
 * @property string $size
 * @property double $price
 * @property int $quantity
 * @property int $customization
 * @property string $additional_notes
 *
 * @property Quotations $quotation
 */
class QuotationDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_misc_quotation_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quotation_id', 'description', 'size', 'price', 'quantity'], 'required'],
            [['quotation_id', 'quantity', 'customization'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string', 'max' => 75],
            [['color'], 'string', 'max' => 25],
            [['size'], 'string', 'max' => 4],
            [['additional_notes'], 'string', 'max' => 45],
            [['quotation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quotations::class, 'targetAttribute' => ['quotation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotation_id' => 'Cotización',
            'description' => 'Descripción',
            'color' => 'Color',
            'size' => 'Talla',
            'price' => 'Precio unitario',
            'quantity' => 'Cantidad',
            'customization' => 'Personalizada',
            'additional_notes' => 'Notas adicionales',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotation()
    {
        return $this->hasOne(Quotations::class, ['id' => 'quotation_id']);
    }
}
