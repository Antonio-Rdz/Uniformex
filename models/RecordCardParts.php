<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_record_card_parts".
 *
 * @property int $id
 * @property int $record_card_id
 * @property int $part_id
 * @property int $quantity
 *
 * @property Parts $part
 * @property RecordCards $recordCard
 */
class RecordCardParts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_record_card_parts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['record_card_id', 'part_id', 'quantity'], 'required'],
            [['record_card_id', 'part_id'], 'integer'],
            [['quantity'], 'number'],
            [['record_card_id', 'part_id'], 'unique', 'targetAttribute' => ['record_card_id', 'part_id'], 'message' => 'Ya has agregado éste avío'],
            [['part_id'], 'exist', 'skipOnError' => true, 'targetClass' => Parts::class, 'targetAttribute' => ['part_id' => 'id']],
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
            'part_id' => 'Avío',
            'quantity' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPart()
    {
        return $this->hasOne(Parts::class, ['id' => 'part_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecordCard()
    {
        return $this->hasOne(RecordCards::class, ['id' => 'record_card_id']);
    }
}
