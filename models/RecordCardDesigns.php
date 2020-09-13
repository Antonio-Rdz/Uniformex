<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_record_card_designs".
 *
 * @property int $id
 * @property int $record_card_id
 * @property string $image
 * @property string $type
 * @property string $location
 * @property string $color_sequence
 * @property string $color_code
 * @property string $stitches
 * @property string $dimensions
 *
 * @property RecordCards $recordCard
 */
class RecordCardDesigns extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_record_card_designs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'type', 'location', 'dimensions'], 'required'],
            [['record_card_id'], 'integer'],
            [['image'], 'string', 'max' => 80],
            [['type', 'color_sequence'], 'string', 'max' => 65],
            [['location'], 'string', 'max' => 140],
            [['color_code', 'stitches'], 'string', 'max' => 45],
            [['dimensions'], 'string', 'max' => 70],
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
            'image' => 'Imagen',
            'location' => 'Ubicación',
            'type' => 'Técnica',
            'color_sequence' => 'Secuencia de colores',
            'color_code' => 'Código de color',
            'stitches' => 'Número de puntadas',
            'dimensions' => 'Dimensiones (cm)',
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
