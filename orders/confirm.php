<?php

/* @var $this yii\web\View */
/* @var $details array */
/* @var $order \app\models\Orders */

use app\models\Clothes;
use app\models\Sizes;
use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;

$this->title = 'Confirmar orden ' . $order->order_number;
$this->params['breadcrumbs'][] = ['label' => 'Ordenes', 'url' => ['/orders/index', 'order_id' => $order->id]];
$this->params['breadcrumbs'][] = ['label' => $order->order_number, 'url' => ['order-details/index', 'order_id' => $order->id]];
$this->params['breadcrumbs'][] = "Confirmar";

$f = Yii::$app->formatter;
?>

<div class="container">

    <div class="row">
        <div class="col s12">
            <h4><?=$this->title?></h4>
            <h5>Cliente <?=$order->customer->name?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <p>Existen piezas en inventario que coniciden con la orden, por favor escribe la cantidad a fabricar.</p>
            <p class="grey-text">Consejo: puedes escribir la cantidad de piezas a fabricar y a comprar o dejar todo en blanco para usar las cantidades recomendadas.</p>
        </div>
    </div>

    <?php ActiveForm::begin(['id' => 'confirm-form']) ?>
    <?php foreach($details as $record_card_id => $detail){ ?>

        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <table class="highlight centered responsive-table">
                            <h5><?=$detail['description'].' '.$detail['model']?></h5>
                            <thead>
                            <tr>
                                <th colspan="5"></th>
                            </tr>
                            <tr>
                                <th>Talla</th>
                                <th>Precio</th>
                                <th>Solicitadas</th>
                                <th>Existencia</th>
                                <th>Fabricar</th>
                                <th>Comprar</th>
                            </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($detail['sizes'] as $size => $info){
                                    $cloth = Clothes::findOne(['record_card_id' => $record_card_id]);
                                    $_size = Sizes::findOne(['name' => $size]);
                                    $stock = 0;
                                    if($cloth){
                                        $stock = $cloth->getStock($_size->id);
                                    }
                                    $needed = $info['quantity'] - $stock;
                                    ?>
                                    <tr>
                                        <td><?=$size?></td>
                                        <td><?=$f->asCurrency($info['price'])?></td>
                                        <td class="needed"><?=$info['quantity']?></td>
                                        <td> <?= $stock ?> </td>
                                        <td><?= Html::input('number', 'Manufacture['.$record_card_id.']['.$size.']', null, ['placeholder' => $needed, 'style' => 'width:auto;text-align:center;', 'class' => 'manufacture']) ?></td>
                                        <td><?= Html::input('number', 'Purchase['.$record_card_id.']['.$size.']', null, ['placeholder' => 0, 'style' => 'width:auto;text-align:center;', 'class' => 'purchase']) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

    <div class="row">
        <div class="col s12 m6 offset-m3">
            <?= Html::submitButton('Confirmar', ['class' => 'btn green darken-1']) ?>
        </div>
    </div>

    <?php ActiveForm::end() ?>

    <?php Yii::$app->customAssets->add('orders/script.js'); ?>

</div>
