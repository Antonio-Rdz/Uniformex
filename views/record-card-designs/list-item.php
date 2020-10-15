<?php

/* @var $model \app\models\RecordCardDesigns */
/* @var $this \yii\web\View */

use yii\helpers\Html;

?>
<li class="collection-item avatar">
    <img src="/uploads/<?=$model->image?>" alt="" class="square new-materialboxed" width="42">
    <span class="title"><?=$model->type?></span>
    <p>
        <?=$model->location?> | <?=$model->dimensions?> | <?=$model->stitches?> puntadas<br>
        Código de color <?=$model->color_code?> | Secuencia de color <?=$model->color_sequence?>
    </p>
    <?php if(Yii::$app->user->getIdentity()->hasAccess("record-card-designs", "delete")){
        echo Html::a('<i class="material-icons">remove_circle_outline</i>', '#!', [
            'class' => 'secondary-content',
            'id' => 'delete-logo',
            'data' => ['id' => $model->id],
        ]);
    } echo Html::hiddenInput("RecordCardDesigns[]", $model->id);
    ?>
</li>