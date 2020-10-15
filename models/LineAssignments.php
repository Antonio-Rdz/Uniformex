<?php

namespace app\models;

use yii\db\Query;

/**
 * This is the model class for table "ufmx_prod_line_assignments".
 *
 * @property int $id
 * @property int $order_detail_id
 * @property int $production_line_id
 * @property int $user_id
 * @property int $created_by
 * @property string $assigned_timestamp
 * @property string $ready_timestamp
 * @property string $completed_timestamp
 * @property int $status
 * @property int $type
 * @property int $production_type_id
 * @property int $quantity
 *
 * @property Clothes[] $clothes
 * @property AssignmentBatch[] $batches
 * @property LineAssignmentDetails[] $details
 * @property OrderDetails $orderDetail
 * @property ProductionLines $productionLine
 * @property ProductionTypes $productionType
 * @property User $user
 * @property User $createdBy
 *
 */
class LineAssignments extends \yii\db\ActiveRecord
{

    // Assignment statuses
    const STATUS = [
        0 => 'Sin iniciar',
        1 => 'En proceso',
        2 => 'En pausa',
        3 => 'Terminado',
        4 => 'Cancelado'
    ];

    const NOT_STARTED = 0;
    const IN_PROGRESS = 1;
    const ON_PAUSE = 2;
    const FINISHED = 3;
    const CANCELED = 4;

    // Assignment types
    const TYPES = [
        0 => 'Corte',
        1 => 'Confección',
        2 => 'Procesos',
    ];

    const CUT = 0;
    const PRODUCTION = 1;
    const FINISHES = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_prod_line_assignments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_detail_id', 'production_line_id', 'user_id', 'created_by', 'quantity'], 'required'],
            [['order_detail_id'], 'required', 'message' => 'Por favor selecciona al menos un concepto'],
            [['order_detail_id', 'production_line_id', 'user_id', 'created_by', 'status', 'type', 'production_type_id', 'quantity'], 'integer'],
            [['assigned_timestamp', 'ready_timestamp', 'completed_timestamp'], 'safe'],
            [['production_line_id', 'order_detail_id'], 'unique', 'targetAttribute' => ['production_line_id', 'order_detail_id'], 'when' => function($model) {
                /* @var $model LineAssignments */
                return $model->orderDetail->hasUnassigned();
            }],
            [['order_detail_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderDetails::class, 'targetAttribute' => ['order_detail_id' => 'id']],
            [['production_line_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductionLines::class, 'targetAttribute' => ['production_line_id' => 'id']],
            [['production_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductionTypes::class, 'targetAttribute' => ['production_type_id' => 'id'], 'when' => function($model) {
                /* @var $model LineAssignments */
                return $model->production_type_id != null;
            }],
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
            'order_detail_id' => 'Concepto',
            'production_line_id' => 'Maquila',
            'user_id' => 'Usuario asignado',
            'created_by' => 'Creado por',
            'assigned_timestamp' => 'Fecha de asignación',
            'ready_timestamp' => 'Fecha de autorización',
            'status' => 'Estatus',
            'type' => 'Tipo',
            'production_type_id' => 'Tipo de proceso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClothes()
    {
        return $this->hasMany(Clothes::class, ['assignment_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBatches()
    {
        return $this->hasMany(AssignmentBatch::class, ['line_assignment_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetails()
    {
        return $this->hasMany(LineAssignmentDetails::class, ['assignment_id' => 'id']);
    }


    /**
     * @return string
     */
    public function getStatus(){
        return self::STATUS[$this->status];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetail()
    {
        return $this->hasOne(OrderDetails::class, ['id' => 'order_detail_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductionLine()
    {
        return $this->hasOne(ProductionLines::class, ['id' => 'production_line_id']);
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
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return float
     */
    public function getProductionCost(){
        $q = (new Query())->select(['cost' => 'SUM(rm.cost)'])
        ->from(['la' => LineAssignments::tableName()])
            ->innerJoin(['lad' => LineAssignmentDetails::tableName()], 'lad.assignment_id = la.id')
        ->leftJoin(['rm' => RawMaterial::tableName()], 'lad.raw_material_id = rm.id')
        ->where('lad.raw_material_id is not null')
        ->andWhere(['la.id' => $this->id])->one();
        // Add an 50% extra value for salaries and other costs. TODO: Confirm the extra amount or make it dynamic
        return round($q['cost']*1.50, 2);
    }

    /**
     * @return array
     */
    public function getProgress(){
        $q1 = (new Query())->select([
            'fabricated' => 'SUM(lh.quantity)',
        ])
            ->from(['lh' => LineHistory::tableName()])
            ->innerJoin(['la' => LineAssignments::tableName()], 'la.id = lh.assignment_id')
            ->where(['la.id' => $this->id])->one();

        $q2 = (new Query())->select([
            'required' => 'SUM(od.quantity)',
        ])
            ->from(['od' => OrderDetails::tableName()])
            ->innerJoin(['la' => LineAssignments::tableName()], 'od.id = la.order_detail_id')
            ->where(['la.id' => $this->id])->one();

        $progress = [
            'fabricated' => (int)$q1['fabricated'],
            'required' => (int)$q2['required'],
            'percentage' => round(($q1['fabricated'] / $q2['required']) * 100),
        ];

        return $progress;
    }

    /**
     * @return float
     */
    public function getHoldTime(){
        $q_start = (new Query())->select(['hold_time_start' => 'ROUND(time_to_sec((TIMEDIFF(MIN(started_timestamp), ready_timestamp))) / 60, 2)'])
            ->from(['lh' => LineHistory::tableName()])
            ->innerJoin(['la' => LineAssignments::tableName()], 'la.id = lh.assignment_id')
            ->where(['assignment_id' => $this->id])->one();

        $q_activities = (new Query())->select(['hold_time_activities' => 'SUM(ROUND(time_to_sec((TIMEDIFF(produced_timestamp, started_timestamp))) / 60, 2))'])
            ->from(['lh' => LineHistory::tableName()])
            ->innerJoin(['la' => LineAssignments::tableName()], 'la.id = lh.assignment_id')
            ->where(['assignment_id' => $this->id])
            ->andWhere('produced_timestamp is not null')->one();

        return (float)$q_start + (float)$q_activities;
    }
}
