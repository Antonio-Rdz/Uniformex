<?php
/* @var $this yii\web\View */
/* @var $clothTypes app\models\ClothTypesRecordCards[] */
?>

<table class="responsive-table centered highlight">
    <thead>
    <tr>
        <th>Tipo</th>
        <th>Color</th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($clothTypes as $clothType){ ?>
        <tr>
            <td><?=$clothType->clothType->name?></td>
            <td><?=$clothType->clothType->color?></td>
        </tr>
    <?php }
    if(empty($clothTypes)){?>
        <tr>
            <td colspan="2">No se han agregado telas</td>
        </tr>
    <?php } ?>
    </tbody>
</table>
