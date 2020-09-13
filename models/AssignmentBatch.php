<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_prod_assignment_batch".
 *
 * @property int $id
 * @property string $quantity
 * @property int $line_assignment_id
 * @property int $user_id
 *
 * @property LineAssignments $lineAssignment
 * @property User $user
 * @property LineHistory[] $lineHistories
 */
class AssignmentBatch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_prod_assignment_batch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantity', 'line_assignment_id', 'user_id'], 'required'],
            [['line_assignment_id', 'user_id'], 'integer'],
            [['quantity'], 'string', 'max' => 45],
            [['line_assignment_id'], 'exist', 'skipOnError' => true, 'targetClass' => LineAssignments::class, 'targetAttribute' => ['line_assignment_id' => 'id']],
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
            'quantity' => 'Quantity',
            'line_assignment_id' => 'Line Assignment ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineAssignment()
    {
        return $this->hasOne(LineAssignments::class, ['id' => 'line_assignment_id']);
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
    public function getLineHistories()
    {
        return $this->hasMany(LineHistory::class, ['batch_id' => 'id']);
    }
}
