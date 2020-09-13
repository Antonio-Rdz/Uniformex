<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_prod_production_lines".
 *
 * @property int $id
 * @property int $status
 * @property int $type
 *
 * @property LineHistory[] $lineHistories
 * @property Warehouses $warehouse
 * @property User $user
 */
class ProductionLines extends \yii\db\ActiveRecord
{

    // Assignment statuses
    const STATUSES = [
        0 =>  "Inactiva",
        1 => "En espera",
        2 => "En uso"
    ];
    const INACTIVE = 0;
    const WAITING = 1;
    const IN_USE = 2;
    // Assignment types
    const TYPES = [
        0 => "Interna",
        1 => "Externa"
    ];
    const INTERNAL = 0;
    const EXTERNAL = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_prod_production_lines';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['status', 'type'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Estatus',
            'type' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineAssignments()
    {
        return $this->hasMany(LineAssignments::class, ['production_line_id' => 'id']);
    }
}
