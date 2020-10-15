<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_misc_states".
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 *
 * @property UfmxCxsCustomerAddresses[] $ufmxCxsCustomerAddresses
 * @property UfmxInvWarehouses[] $ufmxInvWarehouses
 * @property UfmxMiscCities[] $ufmxMiscCities
 */
class States extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_misc_states';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'short_name'], 'required'],
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
            'name' => 'Name',
            'short_name' => 'Short Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUfmxCxsCustomerAddresses()
    {
        return $this->hasMany(UfmxCxsCustomerAddresses::className(), ['state_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUfmxInvWarehouses()
    {
        return $this->hasMany(UfmxInvWarehouses::className(), ['state_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUfmxMiscCities()
    {
        return $this->hasMany(UfmxMiscCities::className(), ['state_id' => 'id']);
    }
}
