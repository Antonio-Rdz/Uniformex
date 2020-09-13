<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ufmx_usr_users_privileges".
 *
 * @property int $id
 * @property int $privilege_id
 * @property int $user_id
 *
 * @property Privileges $privilege
 * @property User $user
 */
class UserPrivileges extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_usr_users_privileges';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'privilege_id', 'user_id'], 'required'],
            [['id', 'privilege_id', 'user_id'], 'integer'],
            [['id'], 'unique'],
            [['privilege_id'], 'exist', 'skipOnError' => true, 'targetClass' => Privileges::class, 'targetAttribute' => ['privilege_id' => 'id']],
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
            'privilege_id' => 'Permiso',
            'user_id' => 'Usuario',
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
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
