<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "ufmx_prod_line_history".
 *
 * @property int $id
 * @property int $batch_id
 * @property string $started_timestamp
 * @property string $produced_timestamp
 * @property int $quantity
 *
 * @property AssignmentBatch $batch
 */
class LineHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_prod_line_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['batch_id'], 'required'],
            [['batch_id', 'quantity'], 'integer'],
            [['started_timestamp', 'produced_timestamp'], 'safe'],
            [['batch_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignmentBatch::class, 'targetAttribute' => ['batch_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'batch_id' => 'Número de lote',
            'started_timestamp' => 'Inicio',
            'produced_timestamp' => 'Término',
            'quantity' => 'Cantidad producida',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBatch()
    {
        return $this->hasOne(AssignmentBatch::class, ['id' => 'batch_id']);
    }

    /**
     * @param $order_detail_id int
     * @return int
     */
    public static function getCreatedPieces($order_detail_id){
        return (int)(new Query())->select(['produced' => 'SUM(lh.quantity)'])
            ->from(['lh' => self::tableName()])
            ->innerJoin(['la' => LineAssignments::tableName()], 'la.id = assignment_id')
            ->where(['la.order_detail_id' => $order_detail_id])
            ->one()['produced'];
    }

    public function getProductionCost(){
        //TODO: Create this function
    }
}
