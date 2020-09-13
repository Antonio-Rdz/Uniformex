<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_part_entries".
 *
 * @property int $id
 * @property int $part_id
 * @property int $warehouse_id
 * @property int $user_id
 * @property int $supplier_id
 * @property string $timestamp
 * @property int $quantity
 * @property double $cost
 *
 * @property Parts $part
 * @property Suppliers $supplier
 * @property Warehouses $warehouse
 * @property User $user
 */
class PartEntries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_part_entries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['part_id', 'warehouse_id', 'user_id', 'supplier_id', 'quantity', 'cost'], 'required'],
            [['part_id', 'warehouse_id', 'user_id', 'supplier_id', 'quantity'], 'integer'],
            [['timestamp'], 'safe'],
            [['cost'], 'number'],
            [['part_id'], 'exist', 'skipOnError' => true, 'targetClass' => Parts::class, 'targetAttribute' => ['part_id' => 'id']],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Suppliers::class, 'targetAttribute' => ['supplier_id' => 'id']],
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
            'part_id' => 'Avío',
            'warehouse_id' => 'Almacén',
            'user_id' => 'Usuario',
            'supplier_id' => 'Proveedor',
            'timestamp' => 'TIempo',
            'quantity' => 'Cantidad',
            'cost' => 'Costo',
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
    public function getSupplier()
    {
        return $this->hasOne(Suppliers::class, ['id' => 'supplier_id']);
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
        // Increase part stock
        $stock = PartWarehouses::findOne(['part_id' => $this->part_id, 'warehouse_id' => $this->warehouse_id]);
        if($stock){
            $stock->stock += $this->quantity;
        } else { // Or create stock record if it does not exist
            $stock = new PartWarehouses();
            $stock->part_id = $this->part_id;
            $stock->warehouse_id = $this->warehouse_id;
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
