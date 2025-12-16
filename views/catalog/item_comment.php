<?php

use yii\bootstrap5\Html;
?>
<div class="card border-light-subtle mb-3">
    <div class="card-header d-flex justify-content-between">
        <div class="d-flex gap-3">
            <?= Yii::$app->formatter->asDatetime($model->created_at, "php:d.m.Y H:i:s") ?>
            <?php /* if ($model->updated_at): ?>
                (отредактирован: <?= Yii::$app->formatter->asDatetime($model->updated_at, "php:d.m.Y H:i:s") ?>)
            <?php endif */ ?>
            <div>
                Пользователь: <?= $model->user->login ?>
            </div>
        </div>

        <div class="d-flex gap-3">
            <?php if ($model->user_id === Yii::$app->user->id): ?>
                <?= Html::a('<i class="fas fa-pencil-alt"></i>', ['/account/comment/write', "product_id" => $model->product_id], ["class" => "text-warning btn-feedback-edit",  "data-pjax" => 0,]) ?>
            <?php endif ?>
        </div>
    </div>
    <div class="card-body">
        <p class="card-text"><?= nl2br($model->text) ?></p>
    </div>
</div>