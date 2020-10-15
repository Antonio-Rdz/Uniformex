<?php

use macgyer\yii2materializecss\lib\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecordCardDesigns */
/* @var $recordCard app\models\RecordCards */
/* @var $uploadModel app\models\UploadForm */

if(isset($recordCard)){
    $this->title = 'Agregar logotipo';
    $this->params['breadcrumbs'][] = 'Inventario';
    $this->params['breadcrumbs'][] = ['label' => 'Fichas', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $recordCard->model, 'url' => ['record-cards/view', 'id' => $recordCard->id]];
    $this->params['breadcrumbs'][] = $this->title; ?>
    <div class="container">
<?php
}

?>

    <div class="row">
        <div class="col m12 s12 l12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12">
            <div class="card white">
                <div class="card-content">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'uploadModel' => $uploadModel,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

<?php if(isset($recordCard)){ ?>
</div>
<?php } ?>