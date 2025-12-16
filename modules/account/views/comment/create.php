<?php

use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Feedback $model */

?>
<div class="comment-create">
    <?php Pjax::begin([
        'id' => 'comment-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
        "options" => [
            'data-close' => 1,
        ]
    ]); ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <?php Pjax::end() ?>
</div>