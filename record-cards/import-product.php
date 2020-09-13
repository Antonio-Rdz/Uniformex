<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecordCardsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Seleccionar producto';
$this->params['breadcrumbs'][] = 'Inventario';
$this->params['breadcrumbs'][] = ['label' => 'Fichas', 'url' => ['record-cards/index']];
$this->params['breadcrumbs'][] = ['label' => 'Crear', 'url' => ['record-cards/create']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12 m12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'responsive-table highlight'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'model',
                    'description',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{select}',
                        'header' => 'Opciones',
                        'buttons' => [
                            'select' => function ($url, $model) {
                                return Html::a('<i class="material-icons">check_circle</i>', $url, [
                                    'data' => [
                                        'position' => 'top',
                                        'tooltip' => 'Seleccionar éste producto',
                                        'pjax' => '0',
                                    ],
                                    'class' => 'tooltipped',
                                ]);
                            },

                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'select') {
                                $url = Url::to(['record-cards/create', 'product_id' => $model->id]);
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
