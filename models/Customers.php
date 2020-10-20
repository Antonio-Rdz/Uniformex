<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "ufmx_cxs_customers".
 *
 * @property int $id
 * @property string $alias
 * @property string $name
 * @property string $rfc
 * @property string $register_time  
 * @property string $last_updated
 *
 * @property CustomerAddresses[] $addresses
 * @property Orders[] $orders
 */
class Customers extends ActiveRecord
{
   
    public $mchkb = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_cxs_customers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        
        return [
            [['mchkb'], 'boolean'],
            [['alias', 'name'], 'required'], 
            [['rfc'], 'string' ,'max' => 45],
            [['r_social'], 'string' ,'max' => 45], 
            [['dom_fiscal'], 'string' ,'max' => 45], 
            [['CFDI'], 'string' ,'max' => 45], 
            [['c_electronico'], 'string' ,'max' => 45], 
            [['rfc'], 'string', 'max' => 45],
            [['alias'], 'string', 'max' => 45],
            [['name'], 'string', 'max' => 60],
            [['register_time', 'last_updated'], 'safe'],
        ]; 
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        
        return [
            'id' => 'ID',
            'alias' => 'Alias',
            'name' => 'Nombre',
            'mchkb' => 'Tengo RFC',
            'rfc' => 'RFC',
            'r_social' => 'Razon Social',
            'dom_fiscal' => 'Domicilio Fiscal',
            'CFDI' => 'Uso de CFDI',
            'c_electronico' => 'Correo Electronico',
            'register_time' => 'Registro',
            'last_updated' => 'Última Modificación',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(CustomerAddresses::class, ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['customer_id' => 'id']);
    }
}
