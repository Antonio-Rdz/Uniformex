<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_prod_line_assignment_details".
 *
 * @property int $id
 * @property int $assignment_id
 * @property int $raw_material_id
 * @property int $semi_cloth_id
 * @property double $quantity
 *
 * @property RawMaterial $rawMaterial
 * @property SemiClothes $semiCloth
 * @property LineAssignments $assignment
 */
class LineAssignmentDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_prod_line_assignment_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assignment_id', 'quantity'], 'required'],
            [['assignment_id', 'raw_material_id', 'semi_cloth_id'], 'integer'],
            [['quantity'], 'number'],
            [['quantity'], 'inStock'],
            [['raw_material_id', 'semi_cloth_id'], 'requireOne'],
            [['raw_material_id'], 'exist', 'skipOnError' => true, 'targetClass' => RawMaterial::class, 'targetAttribute' => ['raw_material_id' => 'id']],
            [['semi_cloth_id'], 'exist', 'skipOnError' => true, 'targetClass' => SemiClothes::class, 'targetAttribute' => ['semi_cloth_id' => 'id']],
            [['assignment_id'], 'exist', 'skipOnError' => true, 'targetClass' => LineAssignments::class, 'targetAttribute' => ['assignment_id' => 'id']],
        ];
    }

    /**
     * @param $attribute
     */
    public function inStock($attribute){
        if($rm = RawMaterial::findOne($this->raw_material_id)){
            if($this->quantity > $rm->getStock()){
                $this->addError($attribute, 'La cantidad debe ser menor o igual al stock disponible');
            }
        }
        else if ($sc = SemiClothes::findOne($this->semi_cloth_id)) {
            $us = $sc->getUnassignedStock();
            if($this->quantity > $sc->getStock() || $us['available'] <= 0){
                $this->addError($attribute, 'La cantidad debe ser menor o igual al stock disponible');
            }
        }
    }

    public function requireOne($attribute){
        if(!$this->raw_material_id && !$this->semi_cloth_id){
            $this->addError($attribute, 'Debes elegir al menos un material o una semiprenda');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'assignment_id' => 'Asignación',
            'raw_material_id' => 'Material',
            'semi_cloth_id' => 'Semiprenda',
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
    public function getSemiCloth()
    {
        return $this->hasOne(SemiClothes::class, ['id' => 'semi_cloth_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignment()
    {
        return $this->hasOne(LineAssignments::class, ['id' => 'assignment_id']);
    }
}
