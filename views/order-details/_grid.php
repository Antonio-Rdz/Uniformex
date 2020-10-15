<?php

/* @var $this yii\web\View */
/* @var $order \app\models\Orders */

use app\models\Orders;
use app\models\Sizes;
use macgyer\yii2materializecss\lib\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

$gridData = $order->getGridData();
$sizes = ArrayHelper::map(Sizes::find()->all(), 'id', 'name');
$t_order = 0;
$num_sizes = count($sizes);
$f = Yii::$app->formatter;
?>
<?php Pjax::begin(); ?>
<div class="container">
    <div class="row">
        <div class="col s12 m2 offset-m11">
            <div class="btn-group" role="group">
                <?= Html::button('<i class="material-icons">view_module</i>', ['class' => "btn btn-inactive tooltipped", 'data' => ['tooltip' => 'Vista general (actual)', 'position' => 'top',]]) ?>
                <?= Html::a('<i class="material-icons">view_list</i>', ['index', 'order_id' => $order->id, 'view' => 'detailed'], ['class' => "btn tooltipped", 'data' => ['tooltip' => 'Vista detallada', 'position' => 'top',]]) ?>
            </div>
        </div>
    </div>
</div>

<?php if(empty($gridData)){ ?>

    <div class="container center">
        <div class="row">
            <div class="col s12">
                <h5 class="grey-text">Nada que mostrar, por favor agrega un concepto a la orden.</h5>
            </div>
        </div>
    </div>

<?php } else { ?>
<table class="highlight centered responsive-table">
    <thead>
    <tr>
        <th colspan="2"></th>
        <th colspan="<?=$num_sizes+1?>">Tallas</th>
    </tr>
    <tr>
        <th>Modelo</th>
        <th>Descripción</th>
        <th>Tela</th>
        <?php foreach ($sizes as $size){ ?>
            <th><?=$size?></th>
        <?php } ?>
        <th>Total</th>
        <th>Opciones</th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($gridData as $record_card_id => $data) { $t_qty = $t_price = 0; ?>
        <tr class="collapse-header">
            <td>
                <?=$data['model']?>
            </td>
            <td>
                <?=$data['description']?>
            </td>
            <td>
                <a class="modal-trigger ignore" id="load_cloth_types" href="#cloth_types" data-id="<?=$record_card_id?>">Ver telas</a>
            </td>
            <?php foreach ($sizes as $id => $size){ ?>
                <td><?= isset($data['sizes'][$size]) ? $data['sizes'][$size]['quantity'] : 0 ?></td>
            <?php $t_qty += isset($data['sizes'][$size]) ? $data['sizes'][$size]['quantity'] : 0; } ?>
            <td>
                <?= $t_qty ?>
            </td>
            <td>
                <?php if(Yii::$app->user->getIdentity()->hasAccess("record-cards", "view")) {
                    echo Html::a('<i class="material-icons ignore">visibility</i>', ['record-cards/view', 'id' => $record_card_id], [
                        'class' => 'tooltipped ignore',
                        'data' => [
                            'tooltip' => 'Ver ficha',
                            'position' => 'top'
                        ]
                    ]);
                }
                if(Yii::$app->user->getIdentity()->hasAccess("order-details", "delete-batch") && $order->status === Orders::NOT_STARTED) {
                        echo Html::a('<i class="material-icons ignore">delete</i>', ['delete-batch', 'order_id' => $order->id, 'record_card_id' => $record_card_id, 'product_id' => $data['product_id']], [
                        'class' => 'tooltipped ignore',
                        'data' => [
                            'tooltip' => 'Eliminar',
                            'position' => 'top',
                            'confirm' => 'No puedes recuperar un concepto eliminado',
                            'method' => 'post'
                        ]
                    ]);
                }?>
            </td>
        </tr>
        <tr class="collapse-body">
            <td colspan="3">
                Observaciones: <?= $data['additional_notes'] ? $data['additional_notes'] : 'Ninguna' ?>
            </td>

            <?php foreach ($sizes as $id => $size){ ?>
                <td><?= isset($data['sizes'][$size]) ? $f->asCurrency($data['sizes'][$size]['price']) : 0 ?></td>
            <?php  $t_price += isset($data['sizes'][$size]) ? ($data['sizes'][$size]['price'] * $data['sizes'][$size]['quantity']) : 0; } ?>
            <td>
                <?= $f->asCurrency($t_price) ?>
            </td>
            <td></td>
        </tr>
    <?php $t_order += $t_price; } ?>
    </tbody>
</table>

<div class="container">
    <div class="row">
        <div class="col s12">
            <h5>Subtotal de la orden: <?= $f->asCurrency($t_order) ?></h5>
        </div>
    </div>
</div>

<!-- Modal Structure -->
<div id="cloth_types" class="modal">
    <div class="modal-content">
        <h4>Telas</h4>
        <div id="ajax_content"></div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
    </div>
</div>
<?php } ?>

<?php Pjax::end(); ?>