<?php

/* @var $this yii\web\View */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;

$this->title = 'Acceso';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <div class="card-panel">
                <div class="center">
                    <i class="material-icons x6">account_circle</i>
                </div>
                <div class="center">
                    <h4><?= Html::encode($this->title) ?></h4>
                </div>
                <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'username')->textInput() ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<label>{input} <span>Mantener sesión iniciada</span></label><div class=\"col s12\">{error}</div>",
                        'class' => 'filled-in'
                    ], false)->label(false) ?>

                    <div class="form-group">
                        <div class="row">
                            <div class="col m12 l12 s12">
                                <?= Html::submitButton('Login', ['class' => 'btn blue darken-1', 'name' => 'login-button']) ?>
                            </div>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>