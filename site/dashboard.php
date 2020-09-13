<?php

/* @var $this yii\web\View */
/* @var $orders array */
/* @var $payments array */


use macgyer\yii2materializecss\lib\Html;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container">
    <h4>Bienvenido.</h4>

    <div class="row">
        <!-- ORDERS -->
        <?php if(!empty($orders)){ ?>
            <div class="col s12 m6 l6">
                <div class="card white">
                    <div class="card-content">
                        <span class="card-title">Ordenes</span>
                        <div class="row">
                            <div class="col s6 m6 l6 center">
                                <h5>
                                    <?= count($orders['due_today']) ?>
                                </h5>
                                <p> Para hoy</p>
                            </div>
                            <div class="col s6 m6 l6 center">
                                <h5>
                                    <?= $overdue = count($orders['overdue']) ?>
                                </h5>
                                <p> Atrasadas <?=$overdue == 0 ? '¡Bien!' : Html::a('Solucionar')?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m12 l12 center">
                                <h5>
                                    <?= count($orders['due_this_week']) ?>
                                </h5>
                                <p>Para ésta semana</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- PAYMENTS -->
        <?php if(!empty($payments)){ ?>
            <div class="col s12 m6 l6">
                <div class="card white">
                    <div class="card-content">
                        <span class="card-title">Ordenes</span>
                        <div class="row">
                            <div class="col s6 m6 l6 center">
                                <h5>
                                    <?= count($orders['due_today']) ?>
                                </h5>
                                <p> Para hoy</p>
                            </div>
                            <div class="col s6 m6 l6 center">
                                <h5>
                                    <?= $overdue = count($orders['overdue']) ?>
                                </h5>
                                <p> Atrasadas <?=$overdue == 0 ? '¡Bien!' : Html::a('Solucionar')?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m12 l12 center">
                                <h5>
                                    <?= count($orders['due_this_week']) ?>
                                </h5>
                                <p>Para ésta semana</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>
