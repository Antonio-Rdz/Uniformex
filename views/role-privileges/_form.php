<?php

use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Privileges;
use app\models\RolePrivileges;


/* @var $this yii\web\View */
/* @var $model app\models\RolePrivileges */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
/* @var $role_id int */

$granted =  ArrayHelper::getColumn(RolePrivileges::find()->where(['role_id' => $role_id])->all(), 'privilege_id');

$privileges = ArrayHelper::map(
    Privileges::find()->joinWith('rolePrivileges', true, 'left join')->where(['not in', 'ufmx_usr_privileges.id', $granted])->all(),
    'id',
    'description'
);
?>

<div>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model,'privilege_id')->dropDownList($privileges); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
