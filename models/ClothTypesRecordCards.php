<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_ord_cloth_types_record_cards".
 *
 * @property int $id
 * @property int $cloth_type_id
 * @property int $record_card_id
 *
 * @property ClothTypes $clothType
 * @property RecordCards $recordCard
 */
class ClothTypesRecordCards extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_ord_cloth_types_record_cards';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cloth_type_id', 'record_card_id'], 'required'],
            [['cloth_type_id', 'record_card_id'], 'integer'],
            [['cloth_type_id', 'record_card_id'], 'unique', 'targetAttribute' => ['cloth_type_id', 'record_card_id']],
            [['cloth_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClothTypes::class, 'targetAttribute' => ['cloth_type_id' => 'id']],
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
            'cloth_type_id' => 'Tela',
            'record_card_id' => 'Ficha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClothType()
    {
        return $this->hasOne(ClothTypes::class, ['id' => 'cloth_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecordCard()
    {
        return $this->hasOne(RecordCards::class, ['id' => 'record_card_id']);
    }
}
