<?php

use yii\bootstrap5\Html;
?>
<div class="admin-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p class="d-flex gap-3">
        <?= Html::a('Управление товарами', ['product/index'], ['class' => 'btn btn-outline-primary']) ?>
        <?= Html::a('Управление категориями', ['category/index'], ['class' => 'btn btn-outline-primary']) ?>
    </p>

</div>