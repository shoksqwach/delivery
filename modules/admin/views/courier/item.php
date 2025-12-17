<?php

use yii\bootstrap5\Html;
?>

<div class="card mb-3">
    <h5 class="card-header"><?= $model->login ?></h5>
    <div class="card-body d-flex flex-column gap-2">
        <div><span class="text-secondary">Имя: </span><span class="fw-bold"><?= $model->name ?></span></div>
        <div><span class="text-secondary">Фамилия: </span><span class="fw-bold"><?= $model->surname ?></span></div>
        <?= $model->patronymic != null
            ? Html::tag('div', Html::tag('span', 'Отчество: ', ['class' => 'text-secondary']) . Html::tag('span', $model->patronymic, ['class' => 'fw-bold']))
            : '' ?>
        <div><span class="text-secondary">Номер телефона: </span><span class="fw-bold"><?= $model->phone ?></span></div>
    </div>
    <div class=" d-flex justify-content-end gap-2 pb-3 pe-3">
        <?= Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => "btn btn-outline-primary"]) ?>
    </div>

</div>