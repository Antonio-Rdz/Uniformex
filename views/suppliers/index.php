<?php

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SuppliersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proveedores';
$this->params['breadcrumbs'][] = 'Inventario';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col s12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <?php if(Yii::$app->user->getIdentity()->hasAccess("suppliers", "create")){ ?>
            <div class="col s12 m4">
                <?= Html::a('<i class="material-icons left">add</i>Crear proveedor', ['create'], ['class' => 'btn']) ?>
            </div>
        <?php } ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'contact_name',
            'phone',
            'email:email',

            [
                'class' => 'macgyer\yii2materializecss\widgets\grid\ActionColumn',
                'template'=>'{update}{delete}',
                'header' => 'Opciones',
                'buttons' => [
                    'update' => function ($url, $model) {
                        if(!Yii::$app->user->getIdentity()->hasAccess("suppliers", "update")){
                            return '';
                        }
                        return Html::a('<i class="material-icons">edit</i>', $url, [
                            'data' => [
                                'position' => 'top',
                                'tooltip' => 'Editar proveedor',
                                'pjax' => '0',
                            ],
                            'class' => 'tooltipped',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        if(!Yii::$app->user->getIdentity()->hasAccess("suppliers", "delete")){
                            return '';
                        }
                        return Html::a('<i class="material-icons">delete</i>', $url, [
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'No puedes recuperar un proveedor eliminado.',
                                'position' => 'top',
                                'tooltip' => 'Eliminar proveedor',
                                'pjax' => '0',
                                'params' => [
                                    'id' => $model->id
                                ],
                            ],
                            'class' => 'tooltipped'
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model) {
                    if ($action === 'delete') {
                        $url = Url::to(['suppliers/delete', 'id' => $model->id]);
                        return $url;
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>
</div>
