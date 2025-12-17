<?php

use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Регистрация курьера';
$this->params['breadcrumbs'][] = ['label' => 'Курьеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>