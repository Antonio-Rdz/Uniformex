<?php

use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use app\models\Privileges;
use yii\helpers\ArrayHelper;
use app\models\UserPrivileges;

/* @var $this yii\web\View */
/* @var $user_id int */
/* @var $model app\models\UserPrivileges */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */


// Get the users privileges
$granted = ArrayHelper::getColumn(UserPrivileges::find()->where(['user_id' => $user_id])->all(), 'privilege_id');

// Get the user possible privileges (exclude the ones he already has)
$privileges = ArrayHelper::map(
        Privileges::find()->joinWith('usersPrivileges', true, 'left join')->where(['not in', 'ufmx_usr_privileges.id', $granted])->all(),
        'id',
        'description'
    );
?>

<div class="user-privileges-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model,'privilege_id')->dropDownList($privileges); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
