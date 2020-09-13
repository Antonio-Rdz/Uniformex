<?php

use macgyer\yii2materializecss\lib\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RecordCards */

$this->title =  "Ficha " .$model->description ." ". $model->model;
$this->params['breadcrumbs'][] = 'Inventario';
$this->params['breadcrumbs'][] = ['label' => 'Fichas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->product->model .'-'. $model->model;
?>'
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card flow-text">
                <div class="card-content">
                    <span class="card-title">Descripción</span>
                    <h5><?= Html::encode($model->description) ?></h5>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col s12 m12 L12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Producto <?= $model->product->model ?>
                        <span class="secondary-content">
                            <?php if(Yii::$app->user->getIdentity()->hasAccess("products", "update")){
                                echo Html::a('<i class="material-icons">edit</i>', ['products/view', 'id' => $model->product_id], [
                                    'class' => 'btn secondary-content tooltipped',
                                    'data' => [
                                        'tooltip' => 'Editar piezas',
                                        'position' => 'top',
                                    ],
                                ]);
                            } ?>
                        </span>
                    </span>
                    <div class="row">
                        <div class="col s12 m4">
                            <?= Html::img('/uploads/'.$model->product->front_image, ['class' => 'responsive-img']) ?>
                        </div>
                        <div class="col s12 m4">
                            <?= Html::img('/uploads/'.$model->product->back_image, ['class' => 'responsive-img']) ?>
                        </div>

                        <div class="col s12 m4" style="overflow: auto;max-height: 300px;">
                            <ul class="collection with-header">
                                <li class="collection-header">
                                    <h5>
                                        Piezas
                                    </h5>
                                </li>
                                <?php foreach ($model->product->pieces as $piece){ /* @var $piece \app\models\ProductPieces */  ?>
                                    <li class="collection-item">
                                        <div>
                                            <?php $q = $piece->quantity; $s = $q != 1 ? 's' : '' ?>
                                            <?= $piece->piece->name ." (".$q." pieza$s)" ?>
                                        </div>
                                    </li>
                                <?php } if(empty($model->product->pieces)){ ?>
                                    <li class="collection-item">
                                        <div class="grey-text">
                                            Sin elementos
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col s12 m12 L12">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <span class="card-title">Dimensiones</span>
                    <div class="row" style="margin: unset">
                        <div class="col s4 m4 l4">
                            Ancho: <b><?= $model->width ?> metros</b>
                        </div>
                        <div class="col s4 m4 l4">
                            Largo: <b><?= $model->height ?> metros</b>
                        </div>
                        <div class="col s4 m4 l4">
                            Peso: <b><?= $model->weight ?> kilogramos</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 L12">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <span class="card-title">Especificaciones</span>
                    <div class="row" style="margin: unset">
                        <div class="col s4 m3 l3">
                            Hilo: <b><?= $model->thread ? $model->thread : 'Ninguno' ?></b>
                        </div>
                        <div class="col s4 m3 l3">
                            Lavado/Planchado: <b><?= $model->laundry ? $model->laundry : 'Ninguno' ?></b>
                        </div>
                        <div class="col s4 m3 l3">
                            Unión: <b><?= $model->union ? $model->union : 'Ninguno' ?></b>
                        </div>
                        <div class="col s12 m3 l3">
                            Sobre costura: <b><?= $model->over_sewing ? $model->over_sewing : 'Ninguno' ?></b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row flex">
        <div class="col s12">
            <div class="card flow-text">
                <div class="card-content">
                    <span class="card-title">Observaciones</span>
                    <p>
                        <?= $model->additional_notes ? $model->additional_notes : '<span class="grey-text"> Nada que mostrar.</span>' ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <ul class="collection with-header">
                <li class="collection-header">
                    <h5>
                        Personalizacion
                        <?php if(Yii::$app->user->getIdentity()->hasAccess("record-card-designs", "create")){
                            echo Html::a('<i class="material-icons">add</i>', ['record-card-designs/create', 'record_card_id' => $model->id], ['class' => 'btn secondary-content']);
                        } ?>
                    </h5>
                </li>
                <?php foreach ($model->designs as $design) { ?>
                    <li class="collection-item avatar">
                        <img src="/uploads/<?=$design->image?>" alt="" class="square new-materialboxed" width="42">
                        <span class="title"><?=$design->type?></span>
                        <p>
                            <?=$design->location?> | <?=$design->dimensions?> | <?=$design->stitches?> puntadas<br>
                            Código de color <?=$design->color_code?> | Secuencia de color <?=$design->color_sequence?>
                        </p>
                        <?php if(Yii::$app->user->getIdentity()->hasAccess("record-card-designs", "update")){
                            echo Html::a('<i class="material-icons">edit</i>', ['record-card-designs/update', 'id' => $design->id, 'record_card_id' => $model->id,], ['class' => 'secondary-content', 'style' => 'margin-right: 30px;']);
                        } ?>

                        <?php if(Yii::$app->user->getIdentity()->hasAccess("record-card-designs", "delete")){
                            echo Html::a('<i class="material-icons">remove_circle_outline</i>', ['record-card-designs/delete', 'id' => $design->id], [
                                'class' => 'secondary-content',
                                'data' => [
                                    'confirm' => '¿Seguro que deseas eliminar este elemento?',
                                    'method' => 'post',
                                ],
                            ]);
                        } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m6">
            <ul class="collection with-header">
                <li class="collection-header">
                   <h5>
                       Materiales
                       <?php if(Yii::$app->user->getIdentity()->hasAccess("record-card-components", "index")){
                           echo Html::a('<i class="material-icons">add</i>', ['record-card-components/create', 'record_card_id' => $model->id], ['class' => 'btn secondary-content']);
                       } ?>
                   </h5>
                </li>
                <?php foreach ($model->components as $component){
                    $s = $component->quantity != 1 ? 's' : ''?>
                    <li class="collection-item">
                        <div>
                            <?= $component->material->name." (".$component->quantity." ".$component->material->unit->name.$s.")" ?>
                            <?php if(Yii::$app->user->getIdentity()->hasAccess("record-card-components", "delete")){
                                echo Html::a('<i class="material-icons">remove_circle_outline</i>', ['record-card-components/delete', 'id' => $component->id, 'record_card_id' => $model->id], [
                                    'class' => 'secondary-content',
                                    'data' => [
                                        'confirm' => '¿Seguro que deseas eliminar este elemento?',
                                        'method' => 'post',
                                    ],
                                ]);
                            } ?>
                        </div>
                    </li>
                <?php } if(empty($model->components)){ ?>
                    <li class="collection-item">
                        <div class="grey-text">
                            Sin elementos
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="col s12 m6">
            <ul class="collection with-header">
                <li class="collection-header">
                    <h5>
                        Avíos
                        <?php if(Yii::$app->user->getIdentity()->hasAccess("record-card-parts", "index")){
                            echo Html::a('<i class="material-icons">add</i>', ['record-card-parts/create', 'record_card_id' => $model->id], ['class' => 'btn secondary-content']);
                        } ?>
                    </h5>
                </li>
                <?php foreach ($model->parts as $part){ /* @var $part \app\models\RecordCardParts */  ?>
                    <li class="collection-item">
                        <div>
                            <?php $s = $part->quantity != 1 ? 's' : '' ?>
                            <?= $part->part->name." (".$part->quantity." ".$part->part->unit->name. "$s)" ?>
                            <?php if(Yii::$app->user->getIdentity()->hasAccess("record-card-parts", "delete")){
                                echo Html::a('<i class="material-icons">remove_circle_outline</i>', ['record-card-parts/delete', 'id' => $part->id, 'record_card_id' => $model->id], [
                                    'class' => 'secondary-content',
                                    'data' => [
                                        'confirm' => '¿Seguro que deseas eliminar este elemento?',
                                        'method' => 'post',
                                    ],
                                ]);
                            } ?>
                        </div>
                    </li>
                <?php } if(empty($model->parts)){ ?>
                    <li class="collection-item">
                        <div class="grey-text">
                            Sin elementos
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>

    </div>

</div>
