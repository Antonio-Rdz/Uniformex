<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_raw_material_entries".
 *
 * @property int $id
 * @property int $raw_material_id
 * @property int $warehouse_id
 * @property int $user_id
 * @property int $supplier_id
 * @property string $timestamp
 * @property double $quantity
 * @property double $cost
 *
 * @property RawMaterial $rawMaterial
 * @property Suppliers $supplier
 * @property User $user
 * @property Warehouses $warehouse
 * @property PurchaseOrderDetails[] $purchaseOrderDetails
 */
class RawMaterialEntries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_raw_material_entries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['raw_material_id', 'warehouse_id', 'user_id', 'supplier_id', 'quantity', 'cost'], 'required'],
            [['raw_material_id', 'warehouse_id', 'user_id', 'supplier_id'], 'integer'],
            [['timestamp'], 'safe'],
            [['quantity', 'cost'], 'number'],
            [['cost'], 'number'],
            [['raw_material_id'], 'exist', 'skipOnError' => true, 'targetClass' => RawMaterial::class, 'targetAttribute' => ['raw_material_id' => 'id']],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Suppliers::class, 'targetAttribute' => ['supplier_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouses::class, 'targetAttribute' => ['warehouse_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'raw_material_id' => 'Material',
            'warehouse_id' => 'Almacén',
            'user_id' => 'Usuario',
            'supplier_id' => 'Proveedor',
            'cost' => 'Costo unitario',
            'timestamp' => 'Creación',
            'quantity' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRawMaterial()
    {
        return $this->hasOne(RawMaterial::class, ['id' => 'raw_material_id']);
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
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouses::class, ['id' => 'warehouse_id']);
    }

    /**
     * @inheritDoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if($insert){
            // Calculate material's new average cost and update last cost
            $material = RawMaterial::findOne($this->raw_material_id);
            $material->cost = $this->cost;
            $material->save();
            // Increase cloth stock
            $stock = MaterialWarehouses::findOne(['material_id' => $this->raw_material_id, 'warehouse_id' => $this->warehouse_id]);
            if($stock){
                $stock->stock += $this->quantity;
            }else{ // Or create stock record if it does not exist
                $stock = new MaterialWarehouses();
                $stock->material_id = $this->raw_material_id;
                $stock->warehouse_id = $this->warehouse_id;
                $stock->stock = $this->quantity;
            }
            if($stock->save()){
                Yii::$app->session->addFlash("success", "Entrada creada con éxito. Inventario actualizado correctamente.");
            } else {
                Yii::$app->session->addFlash("error", "La entrada no pudo ser creada, revisa los datos e intenta de nuevo.");
                $this->delete();
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }
}
