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
            <?php if (Yii::$app->user->identity?->isAdmin): ?>
                <?= Html::a('<i class="fas fa-trash-alt"></i>', ['/admin/comment/delete', "id" => $model->id, 'product_id' => $model->product_id], ["class" => "text-danger btn-feedback-edit",  "data-pjax" => 0, "data-method" => 'post']) ?>
            <?php endif ?>
        </div>
    </div>
    <div class="card-body">
        <p class="card-text"><?= nl2br($model->text) ?></p>
    </div>
</div>