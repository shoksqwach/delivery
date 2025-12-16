<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ReasonCancel $model */

$this->title = 'Отмена заказа №' . $model->order_id . " от " . Yii::$app->formatter->asDatetime($model->order->created_at, "php:d.m.Y H:i:s");
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reason-cancel-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>