<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ufmx_inv_sizes".
 *
 * @property int $id
 * @property string $name
 *
 * @property OrderDetails[] $orderDetails
 */
class Sizes extends \yii\db\ActiveRecord
{

    const DEFAULT_SIZES = [28,30,31,32,33,34,36,38,40,42,44,46];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_inv_sizes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique', 'message' => 'Ya existe esa talla'],
            [['name'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Talla',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetails::class, ['size_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getDefaultSizes(){
        return ArrayHelper::map(self::find()->where(['name' => self::DEFAULT_SIZES])->all(), 'id', 'name');
    }

    /**
     * @return array
     */
    public static function getOtherSizes(){
        return ArrayHelper::map(self::find()->where(['not', ['name' => self::DEFAULT_SIZES]])->all(), 'id', 'name');
    }


}
