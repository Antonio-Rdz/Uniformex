<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "ufmx_ord_order_details".
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $record_card_id
 * @property string $description
 * @property int $size_id
 * @property double $price
 * @property int $quantity The ordered quantity
 * @property int $manufacture_quantity The quantity to be manufactured
 * @property int $purchase_quantity The quantity to be purchased from external provider
 * @property string $additional_notes
 *
 * @property Products $product
 * @property Orders $order
 * @property RecordCards $recordCard
 * @property Sizes $size
 * @property LineAssignments[] lineAssignments
 * @property ProductionLines[] $productionLines
 */
class OrderDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_ord_order_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'record_card_id', 'description', 'size_id', 'price', 'quantity'], 'required'],
            [['order_id', 'product_id', 'record_card_id', 'size_id', 'quantity', 'manufacture_quantity', 'purchase_quantity'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string', 'max' => 75],
            [['additional_notes'], 'string', 'max' => 140],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
            [['record_card_id'], 'exist', 'skipOnError' => true, 'targetClass' => RecordCards::class, 'targetAttribute' => ['record_card_id' => 'id']],
            [['size_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizes::class, 'targetAttribute' => ['size_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Orden',
            'record_card_id' => 'Ficha',
            'description' => 'Concepto',
            'size' => 'Talla',
            'price' => 'Precio unitario',
            'quantity' => 'Cantidad',
            'manufacture_quantity' => 'Cantidad a producir',
            'purchase_quantity' => 'Cantidad a comprar',
            'additional_notes' => 'Notas adicionales',
        ];
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
    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['id' => 'order_id']);
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
    public function getSize()
    {
        return $this->hasOne(Sizes::class, ['id' => 'size_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineAssignments()
    {
        return $this->hasMany(LineAssignments::class, ['order_detail_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getProductionLines()
    {
        return $this->hasMany(ProductionLines::class, ['id' => 'production_line_id'])->viaTable(LineAssignments::tableName(), ['order_detail_id' => 'id']);
    }

    /**
     * @param $order_id
     * @return array
     */
    public static function _findUnassigned($order_id){
        $records = (new Query())->select('od.*')
            ->from(['od' => self::tableName()])
            ->leftJoin(['la' => LineAssignments::tableName()], 'la.order_detail_id = od.id AND la.status <> 3')
            ->where(['od.order_id' => $order_id])
            ->andWhere(['is', 'la.id', null]);

        return $records->all();
    }

    /**
     * @param $order_id
     * @return array
     */
    public function findUnassigned(){
        $records = (new Query())->select('od.*')
            ->from(['od' => self::tableName()])
            ->leftJoin(['la' => LineAssignments::tableName()], 'la.order_detail_id = od.id AND la.status <> 3')
            ->where(['od.order_id' => $this->order_id])
            ->andWhere(['is', 'la.id', null]);

        return $records->all();
    }

    /**
     * @return bool
     */
    public function hasUnassigned(){
        return empty($this->findUnassigned());
    }
}
