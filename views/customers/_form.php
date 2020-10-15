<?php

use yii\helpers\Html;
use yii\helpers\BaseHtml;
use macgyer\yii2materializecss\widgets\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Customers */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
?>
   

<div class="customers-form">

    <?php 
    
    
    
    $form = ActiveForm::begin(); ?> 

    
                                    
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?> 

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


        <?php 
        if ('mchkb' == false) {?>
        <?= 
        $form->field($model, 'mchkb')->checkbox([
                    'template' => "<label>{input} <span>Mantener sesión iniciada</span></label><div class=\"col s12\">{error}</div>",
                    'class' => 'filled-in',
                    'onchange' => 'Url::to(["models/Customers", "mchkb" => true]);'
                ], false)->label(false) ?> <?php }else{ ?>

        <?= 
        $form->field($model, 'mchkb')->checkbox([
                    'template' => "<label>{input} <span>Mantener sesión iniciada</span></label><div class=\"col s12\">{error}</div>",
                    'class' => 'filled-in',
                    'onchange' => 'Url::to(["models/Customers", "mchkb" => false]);'
                    ], false)->label(false) ?><?=    $form->field($model, 'rfc')->textInput(['maxlength' => true]) ?>
        <?=    $form->field($model, 'r_social')->textInput(['maxlength' => true]) ?>
        <?=    $form->field($model, 'dom_fiscal')->textInput(['maxlength' => true]) ?>
        <?=    $form->field($model, 'CFDI')->textInput(['maxlength' => true]) ?>
        <?=    $form->field($model, 'c_electronico')->textInput(['maxlength' => true]) ?>
        <?php } ?>

    
    
    
 
  
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
    </div> 

    <?php ActiveForm::end(); ?>
    
