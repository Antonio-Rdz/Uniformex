<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_record_card_pieces".
 *
 * @property int $id
 * @property int $record_card_id
 * @property string $description
 * @property int $quantity
 *
 * @property RecordCards $recordCard
 */
class RecordCardPieces extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_record_card_pieces';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['record_card_id', 'description', 'quantity'], 'required'],
            [['record_card_id', 'quantity'], 'integer'],
            [['description'], 'string', 'max' => 45],
            [['record_card_id'], 'exist', 'skipOnError' => true, 'targetClass' => RecordCards::class, 'targetAttribute' => ['record_card_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'record_card_id' => 'Ficha',
            'description' => 'Descripción',
            'quantity' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecordCard()
    {
        return $this->hasOne(RecordCards::class, ['id' => 'record_card_id']);
    }
}
