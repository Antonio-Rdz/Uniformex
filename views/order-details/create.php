<?php

use app\lib\Utilities;
use app\models\OrderDetails;
use app\models\Sizes;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\OrderDetails */
/* @var $order \app\models\Orders */
/* @var $cloth \app\models\Clothes */
/* @var $order_id int */
/* @var $cloth \app\models\Clothes */
/* @var $recordCard \app\models\RecordCards */
/* @var $product \app\models\Products */
/* @var $uploadModel \app\models\UploadForm */

$this->title = 'Agregar conceptos a la orden ' . $order->order_number;
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => ['/orders/index', 'order_id' => $order->id]];
$this->params['breadcrumbs'][] = ['label' => $order->order_number, 'url' => ['order-details/index', 'order_id' => $order->id]];
$this->params['breadcrumbs'][] = "Agregar concepto";

$details = OrderDetails::findAll($order_id);
$sizes = Sizes::getDefaultSizes();
?>
<div class="container">

    <div class="row">
        <div class="col s12 m9 l9">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <?php if(!$product && !$cloth){ ?>
        <div class="row">
            <div class="col s12 m6 l6 offset-m3 offset-l3">
                <?=Html::a('<i class="material-icons left">open_in_browser</i> Cargar producto', ['import-product', 'order_id' => $order_id], ['class' => 'btn']);?>
            </div>
        </div>

        <div class="row">
            <div class="divider">
                <span>Ó</span>
            </div>
        </div>

        <div class="row">
            <div class="col s12 m6 l6 offset-m3 offset-l3">
                <?= Html::a('<i class="material-icons left">add</i> Importar prenda', ['import-cloth', 'order_id' => $order_id], ['class' => 'btn']); ?>
            </div>
        </div>
    <?php } ?>

    <?php if($cloth) { ?>
        <div class="row">
            <div class="col s12 m4 l4">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title"><?= $cloth->name ?></span>
                        <p>
                            <?= $cloth->description ?> Color <?= $cloth->color ?> Talla <?= $cloth->size ?>
                        </p>
                    </div>
                    <div class="card-action">
                        <?= Html::a('Más Detalles', ['/clothes/view', 'id' => $cloth->id])  ?>
                        <?= Html::a('Cancelar', ['create'])  ?>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    if($product) { ?>
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title" style="display: inline">Producto: <?= $product->model ?> - <?=$product->description?><?= $recordCard->model ? ' (Variante '.$recordCard->model.')' : '' ?></span>
                        <img src="/uploads/<?=$product->front_image?>" alt="" class="square new-materialboxed" width="64">
                    </div>
                    <div class="card-action">
                        <?= Html::a('Más Detalles', ['/products/view', 'id' => $product->id])  ?>
                        <?= Html::a('Cargar ficha', ['import-record-card', 'product_id' => $product->id, 'order_id' => $order_id])  ?>
                        <?= Html::a('Cancelar', ['create', 'order_id' => $order_id])  ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php $form = ActiveForm::begin(['id' => 'ord-dtl']);?>
    <?php if($product){ ?>
    <div class="row">
        <div class="col s12 m12">
            <div class="card white">
                <div class="card-content">
                    <span class="card-title">Datos generales</span>


                    <div class="row">
                        <div class="input-field col s12 m6">
                            <div class="col s2 inline" style="margin-top:35px">
                                <?= $product->model ?>
                            </div>
                            <div class="col s10">
                                <?= $form->field($recordCard, 'model')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
                            </div>
                        </div>
                        <div class="input-field col s12 m6 inline">
                            <?= $form->field($model, 'description')->textInput([
                                'maxlength' => true,
                                'autocomplete' => 'off',
                                'data-length' => 75,
                                'class' => 'character-count'
                            ]) ?>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col s12 m6">
                            <?= $form->field($model, 'price')->numberInput(['autocomplete' => 'off', 'step' => '.01']) ?>
                        </div>

                        <div class="col s12 m6">
                            <?= $form->field($model, 'additional_notes')->textarea([
                                'maxlength' => true,
                                'autocomplete' => 'off',
                                'data-length' => 140,
                                'class' => 'character-count'
                            ]) ?>
                        </div>
                    </div>

                    <h6>Especificaciones</h6>
                    <div class="row">
                        <div class="col s12 m3 l3">
                            <?= $form->field($recordCard, 'thread')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
                        </div>
                        <div class="col s12 m3 l3">
                            <?= $form->field($recordCard, 'laundry')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
                        </div>
                        <div class="col s12 m3 l3">
                            <?= $form->field($recordCard, 'union')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
                        </div>
                        <div class="col s12 m3 l3">
                            <?= $form->field($recordCard, 'over_sewing')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row" id="clothes_types_card">
        <div class="col s12">
            <div class="card white">
                <div class="card-content">
                    <span class="card-title">Telas</span>

                    <div class="row center">
                        <div class="col s12 m4 offset-m4">
                            <a href="#!" class="btn" id="add_cloth_type">
                                <i class="material-icons left">add</i> Agregar una tela
                            </a>
                        </div>
                    </div>

                    <table id="clothes_types" class="centered responsive-table">
                        <thead>
                        <tr>
                            <th>Tela</th>
                            <th>Color</th>
                            <th>Opciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($recordCard->clothTypesRecordCards as $clothTypesRecordCard){ ?>
                            <tr>
                                <td>
                                    <?= $clothTypesRecordCard->clothType->name ?>
                                    <?= Html::hiddenInput("ClothTypes[{$clothTypesRecordCard->clothType->id}][name]", $clothTypesRecordCard->clothType->name, ['class' => 'cloth-input']); ?>
                                </td>
                                <td>
                                    <?= $clothTypesRecordCard->clothType->color ?>
                                    <?= Html::hiddenInput("ClothTypes[{$clothTypesRecordCard->clothType->id}][color]", $clothTypesRecordCard->clothType->color, ['class' => 'cloth-input']); ?>
                                </td>
                                <td><?= Html::a('<i class="material-icons">delete</i>', '#!', ['class' => 'remove-cloth-type'])?></td>
                            </tr>
                        <?php } if(empty($recordCard->clothTypesRecordCards)){ ?>
                            <tr></tr>
                        <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="card white" id="logos-container">
                <div class="card-content">
                    <span class="card-title">Personalizacion</span>

                    <ul class="collection with-header" id="logos-list">
                        <li class="collection-header">
                            <h5>
                                Logotipos
                                <?php if(Yii::$app->user->getIdentity()->hasAccess("record-card-designs", "create")){
                                    echo \macgyer\yii2materializecss\lib\Html::a('<i class="material-icons">add</i>', '#logos', [
                                            'id' => 'add-logo',
                                            'class' => 'btn modal-trigger secondary-content',
                                            'data' => ['record_card_id' => $model->id]
                                    ]);
                                } ?>
                            </h5>
                        </li>
                        <?php foreach ($recordCard->designs as $design) { ?>
                            <li class="collection-item avatar">
                                <img src="/uploads/<?=$design->image?>" alt="" class="square new-materialboxed" width="42">
                                <span class="title"><?=$design->type?></span>
                                <p>
                                    <?=$design->location?> | <?=$design->dimensions?> | <?=$design->stitches?> puntadas<br>
                                    Código de color <?=$design->color_code?> | Secuencia de color <?=$design->color_sequence?>
                                </p>
                                <?php if(Yii::$app->user->getIdentity()->hasAccess("record-card-designs", "delete")){
                                    echo Html::a('<i class="material-icons">remove_circle_outline</i>', '#!', [
                                        'class' => 'secondary-content',
                                        'id' => 'delete-logo',
                                        'data' => ['id' => $design->id],
                                    ]);
                                } echo Html::hiddenInput("RecordCardDesigns[]", $design->id);
                                ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12">
            <div class="card white">
                <div class="card-content">
                    <div class="row">
                        <div class="col s8">
                            <span class="card-title">Piezas</span>
                        </div>
                        <div class="col s4">
                            <a href="#!" class="btn btn-block" id="add_size">
                                <i class="material-icons left">add</i> Agregar talla
                            </a>
                        </div>
                    </div>
                    <table class="centered responsive-table">
                            <thead>
                                <tr id="head_row">
                                    <th>Tallas</th>
                                    <?php foreach ($sizes as $size){ ?>
                                        <th><?=$size?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                        <tbody>

                        <tr id="sizes_row">
                            <td>Cantidad</td>
                            <?php foreach ($sizes as $id => $size){ ?>
                                <td><?= Html::input('number', 'Sizes['.$id.'][qty]', null, ['autocomplete' => 'off', 'class' => 'center size-input', 'data' => ['id' => $id]]) ?></td>
                            <?php } ?>
                        </tr>

                        <tr id="prices_row">
                            <td>Precio</td>
                            <?php foreach ($sizes as $id => $size){ ?>
                                <td><?= Html::input('number', 'Sizes['.$id.'][price]', null, ['autocomplete' => 'off', 'class' => 'center price-input', 'id' => 'price_'.$id, 'step' => '.01']) ?></td>
                            <?php } ?>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m6 l6 offset-m3 offset-l3">
            <?= Html::submitButton('Guardar', ['class' => 'btn']) ?>
        </div>
    </div>
    <?php } else { ?>


    <?php } ?>
    <?php ActiveForm::end(); ?>

</div>

<div id="logos" class="modal">
    <div class="modal-content">
        <h4 id="logo-title"></h4>
        <div id="logo-form"></div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
    </div>
</div>
<input type="hidden" value="<?=isset($recordCard) ? $recordCard->id : ''?>" id="record_card_id">
<?php Yii::$app->customAssets->add('order-details/size.js'); ?>
<?php Yii::$app->customAssets->add('order-details/add-cloth-type.js'); ?>
<?php Yii::$app->customAssets->add('order-details/logos.js'); ?>


