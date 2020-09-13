<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecordCards */
/* @var $product app\models\Products */
/* @var $uploadModel app\models\UploadForm */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="card white">
    <div class="card-content">

        <?php if(!$product){ ?>
            <div class="row">
                <div class="col s12 m6 l6 offset-m3 offset-l3">
                    <?= \yii\helpers\Html::a('<i class="material-icons left">open_in_browser</i> Cargar producto', ['import-product'], ['class' => 'btn']);?>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col s12">
                    <span class="card-title">Producto: <?= $product->model ?> - <?=$product->description?></span>
                </div>
            </div>
            <div class="row">
                <div class="col s2 offset-s1">
                    <img src="/uploads/<?=$product->front_image?>" alt="" class="square new-materialboxed" width="64">
                </div>
                <div class="col s6">
                    <img src="/uploads/<?=$product->back_image?>" alt="" class="square new-materialboxed" width="64">
                </div>
            </div>

            <div class="card-action">
                <?= \yii\helpers\Html::a('Más Detalles', ['/products/view', 'id' => $product->id])  ?>
                <?= Html::a('Cancelar', ['create'])  ?>
            </div>

        <?php } ?>

    </div>
</div>

<?= $form->field($model, 'product_id')->hiddenInput()->label(false) ?>

<div class="card white">
    <div class="card-content">

    <h6>Dimensiones</h6>
    <div class="row">
        <div class="col s12 m4 l4">
            <?= $form->field($model, 'width')->numberInput(['step' => '.01', 'autocomplete' => 'off']) ?>
        </div>
        <div class="col s12 m4 l4">
            <?= $form->field($model, 'height')->numberInput(['step' => '.01', 'autocomplete' => 'off']) ?>
        </div>
        <div class="col s12 m4 l4">
            <?= $form->field($model, 'weight')->numberInput(['step' => '.01', 'autocomplete' => 'off']) ?>
        </div>
    </div>


    <h6>Identificadores</h6>
    <div class="row">
        <div class="col s12 m6 l6">
            <?= $form->field($model, 'model')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        </div>
        <div class="col s12 m6 l6">
            <?= $form->field($model, 'description')->textInput([
                'maxlength' => true,
                'autocomplete' => 'off',
                'data-length' => 75,
                'class' => 'character-count'
            ]) ?>
        </div>
    </div>

    <h6>Especificaciones</h6>
    <div class="row">
        <div class="col s12 m3 l3">
            <?= $form->field($model, 'thread')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        </div>
        <div class="col s12 m3 l3">
            <?= $form->field($model, 'laundry')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        </div>
        <div class="col s12 m3 l3">
            <?= $form->field($model, 'union')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        </div>
        <div class="col s12 m3 l3">
            <?= $form->field($model, 'over_sewing')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
        </div>
    </div>


    <h6>Extras</h6>
    <?= $form->field($model, 'additional_notes')->textarea([
        'maxlength' => true,
        'autocomplete' => 'off',
        'data-length' => 140,
        'class' => 'character-count'
    ]) ?>

    <div class="row">
        <div class="col s12 m6 l6 offset-m3 offset-l3">
            <?= Html::submitButton('<i class="material-icons left">save</i> Guardar', ['class' => 'btn']) ?>
        </div>
    </div>



    </div>
</div>
    <?php ActiveForm::end(); ?>
