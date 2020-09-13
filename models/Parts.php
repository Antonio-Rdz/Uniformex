<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "ufmx_inv_parts".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property double $cost
 * @property double $average_cost
 * @property int $unit_id
 *
 * @property PartEntries[] $entries
 * @property PartWarehouses[] $warehouses
 * @property Units $unit
 * @property RecordCardParts[] $recordCardParts
 * @property RecordCards[] $recordCards
 */
class Parts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_parts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'unit_id'], 'required'],
            [['cost', 'average_cost'], 'number'],
            [['unit_id'], 'integer'],
            [['name'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 255],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Units::class, 'targetAttribute' => ['unit_id' => 'id']],
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
            'description' => 'Descripción',
            'cost' => 'Costo',
            'average_cost' => 'Costo Promedio',
            'unit_id' => 'Unidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntries()
    {
        return $this->hasMany(PartEntries::class, ['part_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouses()
    {
        return $this->hasMany(PartWarehouses::class, ['part_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Units::class, ['id' => 'unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecordCardParts()
    {
        return $this->hasMany(RecordCardParts::class, ['part_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecordCards()
    {
        return $this->hasMany(RecordCards::class, ['id' => 'record_card_id'])->viaTable('ufmx_inv_record_card_parts', ['part_id' => 'id']);
    }

    /**
     * @return int|string
     */
    public function getStock($size_id = null, $units = false){
        $q = (new Query())->select(['stock' => 'SUM(stock)'])->from(PartWarehouses::tableName())->where(['part_id' => $this->id]);
        if($size_id){
            $q->andWhere(['size_id' => $size_id]);
        }
        $stock =  intval($q->one()['stock']);
        $s = $stock != 1 ? 's' :  '';
        if($units){
            $stock .= " " . $this->unit->short_name . $s;
        }
        return $stock;
    }
}
