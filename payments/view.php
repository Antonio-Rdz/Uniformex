<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Payments */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pagos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container">


    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <?php if(Yii::$app->user->getIdentity()->hasAccess("payments", "update")){ ?>
            <div class="col s12 m6 l6">
                <?= Html::a('<i class="material-icons left">edit</i> Cambiar estatus', ['update', 'id' => $model->id], ['class' => 'btn green darken-1']) ?>
            </div>
        <?php } if(Yii::$app->user->getIdentity()->hasAccess("payments", "cancel")){ ?>
        <div class="col s12 m6 l6">
            <?= Html::a('<i class="material-icons left">cancel</i> Cancelar pago', ['delete', 'id' => $model->id], [
                'class' => 'btn red darken-1',
                'data' => [
                    'confirm' => '¿Seguro que quieres cancelar éste pago?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <?php } ?>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'amount',
                    'paid_date',
                    'status_id',
                    'order_id',
                ],
            ]) ?>
        </div>
    </div>


</div>
