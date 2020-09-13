<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "ufmx_usr_users".
 *
 * @property int $id
 * @property string $user
 * @property string $password
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $birthday
 * @property string $authKey
 * @property string $access_token
 *
 * @property ClothEntries[] clothEntries
 * @property RawMaterialEntries[] rawMaterialEntries
 * @property Quotations[] $quotations
 * @property ProductionLines[] productionLines
 * @property Privileges[] $privileges
 * @property Roles[] $roles
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    public $password_confirm;
    const SCENARIO_CHANGE_PASSWORD = 'change-password';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ufmx_usr_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'password', 'email', 'first_name', 'last_name'], 'required'],
            [['user'], 'string', 'max' => 16],
            [['password'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 50],
            ['email', 'email'],
            [['first_name', 'last_name'], 'string', 'max' => 60],
            [['authKey', 'access_token'], 'string', 'max' => 128],
            ['password_confirm', 'required', 'on' => self::SCENARIO_CHANGE_PASSWORD],
            ['password_confirm', 'password_match', 'on' => self::SCENARIO_CHANGE_PASSWORD],

        ];
    }

    /**
     * @inheritDoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CHANGE_PASSWORD] = ['password_confirm', 'password'];
        return $scenarios;
    }

    /**
     * @param $attribute
     */
    public function password_match($attribute){
        if ($this->password_confirm != $this->password) {
            $this->addError($attribute, 'Las contraseñas deben coincidir');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'Usuario',
            'password' => 'Contraseña',
            'password_confirm' => 'Confirmar contraseña',
            'email' => 'Email',
            'first_name' => 'Nombre(s)',
            'last_name' => 'Apellido(s)',
            'birthday' => 'Cumpleaños',
            'authKey' => 'Auth Key',
            'access_token' => 'Access Token',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotations()
    {
        return $this->hasMany(Quotations::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrivileges()
    {
        return $this->hasMany(UserPrivileges::class, ['user_id' => 'id']);
    }

    /**
     * Gets a privilege for the current user model
     *
     * @param $privilege Privileges A Privileges model to evaluate
     * @return array
     */
    public function getPrivilege($privilege)
    {
        if($privilege){
            return $this->hasMany(UserPrivileges::class, ['user_id' => 'id'])->where(['privilege_id' => $privilege->id])->all();
        }
        return [];
    }


    /**
     * Gets a privilege for all of the current user model roles
     *
     * @param $controller string The name of the controller
     * @param $action string The name of the action
     *
     * @return array
     */
    public function getRolePrivilege($privilege){
        $privileges = [];

        $user_roles = $this->hasMany(UserRoles::class, ['user_id' => 'id'])->all();

        if($user_roles){
            foreach ($user_roles as $user_role) {
                if($role_privilege = RolePrivileges::findOne(['role_id' => $user_role, 'privilege_id' => $privilege->id])){
                    $privileges[] = $role_privilege;
                }
            }
        }

        return $privileges;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(UserRoles::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductionLines()
    {
        return $this->hasMany(ProductionLines::class, ['user_id' => 'id']);
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findByUsername($username){
        if($user = self::findOne(['user' => $username])){
            return $user;
        } else {
            return self::findOne(['email' => $username]);
        }
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled. The returned key will be stored on the
     * client side as a cookie and will be used to authenticate user even if PHP session has been expired.
     *
     * Make sure to invalidate earlier issued authKeys when you implement force user logout, password change and
     * other scenarios, that require forceful access revocation for old sessions.
     *
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates the user's password using PHP's password_verify
     * @param $password string The password to compare
     * @return bool
     */
    public function validatePassword($password)
    {
        return password_verify($password, $this->password);
    }


    /**
     * Returns the user's full name (first name + last name)
     *
     * @return string The user's full name
     */
    public function getFullName()
    {
        return $this->first_name. ' ' .$this->last_name;
    }


    /**
     * Determines if a user has access to a view or action based on it granted privileges and to its role (if it has one)
     *
     * @return bool
     */
    public function hasAccess($controller, $action){
        $privilege = Privileges::findOne(['controller' => $controller, 'action' => $action]);
        if(!$privilege){
            return true;
        }

        $privileges = $this->getPrivilege($privilege);
        $roles = $this->getRolePrivilege($privilege);

        return !empty($privileges) || !empty($roles);
    }

}
