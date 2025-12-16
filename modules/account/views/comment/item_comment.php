<?php

use yii\bootstrap5\Html;
?>
<div class="card border-light-subtle mb-3">
    <div class="card-header d-flex justify-content-between">
        <div class="d-flex gap-3">
            <?= Yii::$app->formatter->asDatetime($model->created_at, "php:d.m.Y H:i:s") ?>
        </div>


        <div class="d-flex gap-3">

            <?= Html::a('<i class="far fa-trash-alt"></i>', ['delete', "id" => $model->id], ["class" => "text-danger",  "data-pjax" => 0, "data-method" => "POST"]) ?>

        </div>
    </div>
    <div class="card-body">
        <h5 class="card-title"><?= $model->product->title ?></h5>
        <p class="card-text"><?= nl2br($model->text) ?></p>
    </div>

</div>