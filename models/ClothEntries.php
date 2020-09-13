<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "ufmx_inv_cloth_entries".
 *
 * @property int $id
 * @property int $warehouse_id
 * @property int $cloth_id
 * @property int $user_id
 * @property int $supplier_id
 * @property int $size_id
 * @property string $timestamp
 * @property int $quantity
 * @property double $cost
 *
 * @property Suppliers $supplier
 * @property Clothes $cloth
 * @property Sizes $size
 * @property Warehouses $warehouse
 * @property User $user
 */
class ClothEntries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_cloth_entries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['warehouse_id', 'cloth_id', 'user_id', 'supplier_id', 'size_id', 'quantity', 'cost'], 'required'],
            [['warehouse_id', 'cloth_id', 'user_id', 'supplier_id', 'size_id', 'quantity'], 'integer'],
            [['timestamp'], 'safe'],
            [['cost'], 'number'],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Suppliers::class, 'targetAttribute' => ['supplier_id' => 'id']],
            [['cloth_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clothes::class, 'targetAttribute' => ['cloth_id' => 'id']],
            [['size_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizes::class, 'targetAttribute' => ['size_id' => 'id']],
            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouses::class, 'targetAttribute' => ['warehouse_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'warehouse_id' => 'Almacén',
            'cloth_id' => 'Prenda',
            'user_id' => 'Usuario',
            'supplier_id' => 'Proveedor',
            'size_id' => 'Talla',
            'timestamp' => 'Fecha y hora',
            'quantity' => 'Cantidad',
            'cost' => 'Costo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Suppliers::class, ['id' => 'supplier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCloth()
    {
        return $this->hasOne(Clothes::class, ['id' => 'cloth_id']);
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
    public function getWarehouse()
    {
        return $this->hasOne(Warehouses::class, ['id' => 'warehouse_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @inheritDoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        // Calculate clothes' new average cost and update last cost
        $cloth = Clothes::findOne($this->cloth_id);
        $cloth->average_cost = Clothes::getAverageCost($this->cloth_id);
        $cloth->save();
        // Increase cloth stock
        $stock = ClothesWarehouses::findOne(['cloth_id' => $this->cloth_id, 'warehouse_id' => $this->warehouse_id, 'size_id' => $this->size_id]);
        if($stock){
            $stock->stock += $this->quantity;
        } else { // Or create stock record if it does not exist
            $stock = new ClothesWarehouses();
            $stock->cloth_id = $this->cloth_id;
            $stock->warehouse_id = $this->warehouse_id;
            $stock->size_id = $this->size_id;
            $stock->stock = $this->quantity;
        }
        if($stock->save()){
            Yii::$app->session->addFlash("success", "Entrada creada con éxito. Inventario actualizado correctamente.");
        } else {
            Yii::$app->session->addFlash("error", "La entrada no pudo ser creada, revisa los datos e intenta de nuevo.");
            $this->delete();
        }
        return parent::afterSave($insert, $changedAttributes);
    }
}
