<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_usr_roles".
 *
 * @property int $id
 * @property string $name
 * @property string $common_name
 *
 * @property RolePrivileges[] $ufmxUsrRolePrivileges
 * @property UserRoles[] $ufmxUsrUsersRoles
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_usr_roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 45],
            [['common_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Identificador',
            'common_name' => 'Nombre común'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolePrivileges()
    {
        return $this->hasMany(RolePrivileges::class, ['role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersRoles()
    {
        return $this->hasMany(UserRoles::class, ['role_id' => 'id']);
    }
}
