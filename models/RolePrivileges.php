<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_usr_role_privileges".
 *
 * @property int $id
 * @property int $role_id
 * @property int $privilege_id
 *
 * @property Privileges $privilege
 * @property Roles $role
 */
class RolePrivileges extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_usr_role_privileges';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'privilege_id'], 'required'],
            [['id', 'role_id', 'privilege_id'], 'integer'],
            [['id'], 'unique'],
            [['privilege_id'], 'exist', 'skipOnError' => true, 'targetClass' => Privileges::class, 'targetAttribute' => ['privilege_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Rol',
            'privilege_id' => 'Permiso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrivilege()
    {
        return $this->hasOne(Privileges::class, ['id' => 'privilege_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Roles::class, ['id' => 'role_id']);
    }
}
