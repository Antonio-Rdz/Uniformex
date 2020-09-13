<?php

use macgyer\yii2materializecss\lib\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = $model->model;
$this->params['breadcrumbs'][] = 'Inventario';
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <?php if(Yii::$app->user->getIdentity()->hasAccess("products", "update")){ ?>
            <div class="col s12 m6 l6">
                <?= Html::a('<i class="material-icons left">edit</i> Editar', ['update', 'id' => $model->id], ['class' => 'btn green darken-1']) ?>
            </div>
        <?php }
        if(Yii::$app->user->getIdentity()->hasAccess("products", "delete")){ ?>
            <div class="col s12 m6 l6">
                <?= Html::a('<i class="material-icons left">delete</i> Eliminar', ['delete', 'id' => $model->id], [
                    'class' => 'btn red darken-1',
                    'data' => [
                        'confirm' => '¿Seguro que deseas eliminar este elemento?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        <?php } ?>
    </div>


    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card flow-text">
                <div class="card-content">
                    <span class="card-title"><?=$model->model?></span>
                    <h5><?= Html::encode($model->description) ?></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row flex">

        <div class="col s12 m4">
            <ul class="collection with-header">
                <li class="collection-header">
                    <h5>
                        Piezas
                        <?php if(Yii::$app->user->getIdentity()->hasAccess("product-pieces", "index")){
                            echo Html::a('<i class="material-icons">add</i>', ['product-pieces/create', 'product_id' => $model->id], [
                                'class' => 'btn secondary-content tooltipped',
                                'data' => [
                                    'tooltip' => 'Añadir pieza',
                                    'position' => 'top',
                                ],
                            ]);
                        } ?>
                    </h5>
                </li>
                <?php foreach ($model->pieces as $piece){ /* @var $piece \app\models\ProductPieces */  ?>
                    <li class="collection-item">
                        <div>
                            <?php $q = $piece->quantity; $s = $q != 1 ? 's' : '' ?>
                            <?= $piece->piece->name ." (".$q." pieza$s)" ?>
                            <?php if(Yii::$app->user->getIdentity()->hasAccess("product-pieces", "delete")){
                                echo Html::a('<i class="material-icons">remove_circle_outline</i>', ['product-pieces/delete', 'id' => $piece->id, 'product_id' => $model->id], [
                                    'class' => 'secondary-content tooltipped',
                                    'data' => [
                                        'confirm' => 'Puedes voler a agregar la pieza después',
                                        'method' => 'post',
                                        'tooltip' => 'Remover pieza',
                                        'position' => 'top',
                                    ],
                                ]);
                            } ?>
                        </div>
                    </li>
                <?php } if(empty($model->pieces)){ ?>
                    <li class="collection-item">
                        <div class="grey-text">
                            Sin elementos
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="col s12 m4">
            <div class="card">
                <div class="card-image">
                    <img src="/uploads/<?=$model->front_image?>">
                    <span class="card-title bkg">Frente</span>
                </div>
            </div>
        </div>

        <div class="col s12 m4">
            <div class="card">
                <div class="card-image">
                    <img src="/uploads/<?=$model->back_image?>">
                    <span class="card-title bkg">Espalda</span>
                </div>
            </div>
        </div>

    </div>


</div>
