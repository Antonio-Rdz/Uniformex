<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "ufmx_inv_clothes".
 *
 * @property int $id
 * @property string $name
 * @property double $average_cost
 * @property double $profit_margin
 * @property int $record_card_id
 *
 * @property ClothEntries[] $clothEntries
 * @property RecordCards $recordCard
 * @property ClothesWarehouses[] $inventory
 * @property Warehouses[] $warehouses
 */
class Clothes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_clothes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'average_cost', 'record_card_id'], 'required'],
            [['average_cost', 'profit_margin'], 'number'],
            [['record_card_id'], 'integer'],
            [['name'], 'string', 'max' => 75],
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
            'name' => 'Nombre',
            'average_cost' => 'Costo promedio',
            'profit_margin' => 'Margen de ganancia (%)',
            'record_card_id' => 'Ficha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecordCard()
    {
        return $this->hasOne(RecordCards::class, ['id' => 'record_card_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventory()
    {
        return $this->hasMany(ClothesWarehouses::class, ['cloth_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetails::class, ['cloth_id' => 'id']);
    }

    /**
     * @return int
     */
    public function getStock($size_id = null){
        $q = (new Query())->select(['stock' => 'SUM(stock)'])->from(ClothesWarehouses::tableName())->where(['cloth_id' => $this->id]);
        if($size_id){
            $q->andWhere(['size_id' => $size_id]);
        }
        return intval($q->one()['stock']);
    }

    /**
     * @param $cloth_id int
     * @return float
     */
    public static function getAverageCost($cloth_id){
        $items = (new Query())->select(['avg_cost' => 'ROUND(AVG(cost), 2)'])
            ->from(ClothEntries::tableName())
            ->where(['cloth_id' => $cloth_id])
            ->one();
        return (float)$items['avg_cost'];
    }

    /**
     * @inheritDoc
     */
    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if($this->isNewRecord){
            $this->average_cost = 0;
        } else {
            $this->average_cost = self::getAverageCost($this->id);
        }

        return true;
    }

}