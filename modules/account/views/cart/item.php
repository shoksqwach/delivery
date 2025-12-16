<?php

use yii\bootstrap5\Html;
?>
<div class="card mb-3">
    <div class="card-body d-flex justify-content-between">
        <div class="d-flex">
            <?= Html::img('/img/' . $model->product->productImage->photo, ['class' => 'w-25']) ?>
            <h5 class=""><?= Html::a($model->product->title, ["/catalog/view", "id" => $model->product->id]) ?></h5>
        </div>
        <div class="d-flex gap-3">
            <div><?= Html::a('-', ['dec', 'item_id' => $model->id], ['class' => 'text-decoration-none cart-btn', 'data-pjax' => 0]) ?></div>
            <div><?= $model->amount ?></div>
            <div><?= Html::a('+', ['add', 'product_id' => $model->product_id], ['class' => 'text-decoration-none  cart-btn', 'data-pjax' => 0]) ?></div>
            <div><?= $model->cost ?></div>
            <div><?= $model->sum ?></div>
            <div><?= Html::a('🗑', ['delete', 'item_id' => $model->id], ['data-pjax' => 0, 'class' => 'text-decoration-none  cart-btn']) ?></div>
        </div>

    </div>
</div>