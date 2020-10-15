
<?php

use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
$this->title = 'Cambiar contraseña';
$this->params['breadcrumbs'][] = ['label' => 'Ajustes', 'url' => ['settings']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card white">
                <div class="card-content">
                    <div class="user-form">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'autocomplete' => 'off'])->label('Nueva contraseña') ?>

                        <?= $form->field($model, 'password_confirm')->passwordInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
