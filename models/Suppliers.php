<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_suppliers".
 *
 * @property int $id
 * @property string $name
 * @property string $contact_name
 * @property string $phone
 * @property string $email
 *
 * @property ClothEntries[] $clothEntries
 * @property RawMaterialEntries[] $rawMaterialEntries
 */
class Suppliers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_suppliers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'email'], 'required'],
            [['name'], 'string', 'max' => 80],
            [['contact_name'], 'string', 'max' => 90],
            [['phone'], 'string', 'max' => 15],
            [['email'], 'string', 'max' => 64],
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
            'contact_name' => 'Nombre de contacto',
            'phone' => 'Teléfono',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClothEntries()
    {
        return $this->hasMany(ClothEntries::class, ['supplier_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRawMaterialEntries()
    {
        return $this->hasMany(RawMaterialEntries::class, ['supplier_id' => 'id']);
    }
}
