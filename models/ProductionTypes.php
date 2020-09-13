<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_prod_production_types".
 *
 * @property int $id
 * @property string $name
 *
 * @property LineAssignments[] $lineAssignments
 */
class ProductionTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_prod_production_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 45],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineAssignments()
    {
        return $this->hasMany(LineAssignments::class, ['production_type_id' => 'id']);
    }
}
