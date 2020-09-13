<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_pieces".
 *
 * @property int $id
 * @property string $name
 *
 * @property ProductPieces[] $productPieces
 * @property RecordCardPieces[] $recordCardPieces
 */
class Pieces extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_pieces';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique', 'message' => 'Ya existe una pieza llamada así'],
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
    public function getProductPieces()
    {
        return $this->hasMany(ProductPieces::class, ['piece_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecordCardPieces()
    {
        return $this->hasMany(RecordCardPieces::class, ['piece_id' => 'id']);
    }
}
