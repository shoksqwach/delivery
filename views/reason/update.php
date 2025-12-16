<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ReasonCancel $model */

$this->title = 'Update Reason Cancel: ' . $model->order_id;
$this->params['breadcrumbs'][] = ['label' => 'Reason Cancels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->order_id, 'url' => ['view', 'order_id' => $model->order_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="reason-cancel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
