<?php

use yii\bootstrap5\Html;



?>

<div class="card mb-3">
    <h5 class="card-header"><?= "Заказ №" . $model->id . " от " . Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s'); ?></h5>
    <div class="card-body d-flex flex-column gap-2">
        <div><span class="text-secondary">Имя клиента: </span><span class="fw-bold"><?= $model->user->name ?></span></div>
        <div><span class="text-secondary">Фамилия клиента: </span><span class="fw-bold"><?= $model->user->surname ?></span></div>
        <?= $model->user->patronymic != null
            ? Html::tag('div', Html::tag('span', 'Отчество клиента: ', ['class' => 'text-secondary']) . Html::tag('span', $model->user->patronymic, ['class' => 'fw-bold']))
            : '' ?>
        <div><span class="text-secondary">Количество товаров: </span><span class="fw-bold"><?= $model->amount ?></span></div>
        <div><span class="text-secondary">Сумма заказа:</span> <span class="fw-bold"><?= $model->sum ?></span></div>

        <div><span class="text-secondary">Статус заказа: </span><span class="order-status fw-bold order-<?= $statuses[$model->status_id]['alias'] ?>"> <?= $statuses[$model->status_id]['title'] ?></span></div>
    </div>
    <div class="d-flex justify-content-end gap-2 p-2">
        <?php
        switch ($model->status_id) {
            case $status_order['new']:
                echo  Html::a('Отменить заказ', ['/reason/create', 'order_id' => $model->id], ['class' => "btn btn-outline-danger"]);
                echo Html::a('В обработку', ['change-status', 'order_id' => $model->id, 'status_id' => $status_order["in processing"]], ['class' => "btn btn-outline-info", "data-method" => "post"]);
                break;
            case $status_order['in processing']:
                echo Html::a('Заказ выполнен', ['change-status', 'order_id' => $model->id, 'status_id' => $status_order["final"]], ['class' => "btn btn-outline-success", "data-method" => "post"]);
        } ?>




        <?= Html::a('Состав заказа', ['view', 'id' => $model->id], ['class' => "btn btn-outline-primary"]) ?>
    </div>

</div>