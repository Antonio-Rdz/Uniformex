<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RawMaterialEntriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Entradas de material';
$this->params['breadcrumbs'][] = ['label' => 'Inventario'];
$this->params['breadcrumbs'][] = ['label' => 'Materiales', 'url' => '/raw-material/index'];
$this->params['breadcrumbs'][] = ['label' => 'Entradas'];
?>
<div class="container">
    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <?php if(Yii::$app->user->getIdentity()->hasAccess("raw-material-entries", "create")){ ?>
            <div class="col s12 m4 l4">
                <?= Html::a('<i class="material-icons left">add</i> Crear entrada de material', ['create'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'responsive-table'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'warehouse',
                        'value' => 'warehouse.name',
                        'label' => 'Almacén'
                    ],
                    [
                        'attribute' => 'rawMaterial',
                        'value' => 'rawMaterial.name',
                        'label' => 'Prenda'
                    ],
                    [
                        'attribute' => 'user',
                        'value' => 'user.user',
                        'label' => 'Usuario'
                    ],
                    'cost:currency',
                    [
                        'attribute' => 'quantity',
                        'value' => function($data){
                            /* @var $data \app\models\RawMaterialEntries */
                            $s = $data->quantity != 1 ? "s" : "";
                            return $data->quantity. " " .$data->rawMaterial->unit->name.$s;
                        }
                    ],
                    'timestamp:datetime',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{undo}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'undo' => function ($url, $model) {
                                $date_now = new DateTime();
                                $date_old = new DateTime($model->timestamp);
                                $diff = $date_old->diff($date_now);
                                $hours = $diff->h + ($diff->days*24);
                                if ($hours > 8 || !Yii::$app->user->getIdentity()->hasAccess("raw-material-entries", "delete")) {
                                    return '';
                                } else {
                                    return Html::a('<i class="material-icons">undo</i>', $url, [
                                        'title' => Yii::t('app', 'Revertir'),
                                        'data' => [
                                            'method' => 'post',
                                            'confirm' => 'No puedes recuperar una entrada revertida',
                                            'position' => 'top',
                                            'tooltip' => 'Revertir entrada',
                                            'pjax' => '0',
                                            'params' => [
                                                'id' => $model->id
                                            ],
                                        ],
                                        'class' => 'tooltipped'
                                    ]);
                                }
                            },
                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'undo') {
                                $url = Url::to(['raw-material-entries/delete', 'id' => $model->id]);
                                return $url;
                            }
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
