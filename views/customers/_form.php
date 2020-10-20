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
 <?= 
        $form->field($model, 'mchkb')->checkbox([
                    'class' => 'filled-in',
                    ], false)->label(false) ?>

        <?php if('mchkb' == true){ ?>
        <?=    $form->field($model, 'rfc')->textInput(['maxlength' => true]) ?>
        <?=    $form->field($model, 'r_social')->textInput(['maxlength' => true]) ?>
        <?=    $form->field($model, 'dom_fiscal')->textInput(['maxlength' => true]) ?>
        <?=    $form->field($model, 'CFDI')->textInput(['maxlength' => true]) ?>
        <?=    $form->field($model, 'c_electronico')->textInput(['maxlength' => true]) ?>
        <?php }else {} ?>
    
    
    
 
  
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
    </div> 

    <?php ActiveForm::end(); ?>
    
