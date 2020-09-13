<?php

use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\UserRoles;
use app\models\Roles;


/* @var $this yii\web\View */
/* @var $model app\models\UserRoles */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
/* @var $user_id int */


// Get the users roles
$roles = ArrayHelper::getColumn(UserRoles::find()->where(['user_id' => $user_id])->all(), 'role_id');

// Get the user possible roles (exclude the ones he already has)
$available_roles = ArrayHelper::map(
    Roles::find()->joinWith('usersRoles', true, 'left join')->where(['not in', Roles::tableName().'.id', $roles])->all(),
    'id',
    'common_name'
);
?>

<div class="user-roles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model,'role_id')->dropDownList($available_roles)->label('Rol'); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
