<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClothTypesRecordCards */

$this->title = 'Create Cloth Types Record Cards';
$this->params['breadcrumbs'][] = ['label' => 'Cloth Types Record Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cloth-types-record-cards-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
