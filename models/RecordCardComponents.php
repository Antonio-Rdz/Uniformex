<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_record_card_components".
 *
 * @property int $id
 * @property int $record_card_id
 * @property int $material_id
 * @property double $quantity
 *
 * @property RawMaterial $material
 * @property RecordCards $recordCard
 */
class RecordCardComponents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_record_card_components';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['record_card_id', 'material_id', 'quantity'], 'required'],
            [['record_card_id', 'material_id'], 'integer'],
            [['quantity'], 'number'],
            [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => RawMaterial::class, 'targetAttribute' => ['material_id' => 'id']],
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
            'material_id' => 'Material',
            'quantity' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(RawMaterial::class, ['id' => 'material_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecordCard()
    {
        return $this->hasOne(RecordCards::class, ['id' => 'record_card_id']);
    }
}
