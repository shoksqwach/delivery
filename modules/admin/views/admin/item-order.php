<?php

use yii\bootstrap5\Html;
?>
<div class="card mb-3">
    <div class="d-flex row">
        <div class="d-flex col-9">
            <?= Html::img('/img/' . $model->product->productImage->photo, ['class' => 'w-25']) ?>
            <h5 class="mx-3"><?= Html::a($model->product->title, '') ?></h5>
        </div>
        <div class="d-flex gap-5 col-2 ps-3 fw-semibold">
            <div><?= $model->amount ?></div>
            <div><?= $model->cost ?></div>
            <div><?= $model->sum ?></div>
        </div>

    </div>
</div>