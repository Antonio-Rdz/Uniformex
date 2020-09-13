<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_usr_privileges".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $controller
 * @property string $action
 *
 * @property RolePrivileges[] $rolePrivileges
 * @property UserPrivileges[] $usersPrivileges
 */
class Privileges extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_usr_privileges';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'controller', 'action', 'description'], 'required', 'message' => 'Éste campo no puede estar vacío'],
            [['id'], 'integer'],
            [['name', 'controller', 'action'], 'string', 'max' => 45],
            [['description'], 'string', 'max' => 45],
            [['id', 'name'], 'unique'],
            [['controller', 'action'], 'unique', 'targetAttribute' => ['controller', 'action']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Permiso',
            'description' => 'Descripción',
            'controller' => 'Controlador',
            'action' => 'Acción'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolePrivileges()
    {
        return $this->hasMany(RolePrivileges::class, ['privilege_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersPrivileges()
    {
        return $this->hasMany(UserPrivileges::class, ['privilege_id' => 'id']);
    }
}
