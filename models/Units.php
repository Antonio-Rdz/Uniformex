<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_inv_units".
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 *
 * @property RawMaterial[] $rawMaterials
 * @property Clothes[] $clothes
 */
class Units extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_units';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'short_name'], 'string', 'max' => 45],
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
            'short_name' => 'Abreviatura',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUfmxInvRawMaterials()
    {
        return $this->hasMany(RawMaterial::class, ['unit_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUfmxInvSemiClothes()
    {
        return $this->hasMany(SemiClothes::class, ['unit_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUfmxInvWears()
    {
        return $this->hasMany(Clothes::class, ['unit_id' => 'id']);
    }
}
