<?php

use app\models\Order;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\OrderSerach $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Панель администратора';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h3><?= Html::encode($this->title) ?></h3>


    <p class="d-flex gap-3 my-3">
        <?= Html::a('Управление товарами', ['product/index'], ['class' => 'btn btn-outline-primary']) ?>
        <?= Html::a('Управление категориями', ['category/index'], ['class' => 'btn btn-outline-primary']) ?>
    </p>

    <div class="mt-5">

        <?php Pjax::begin(); ?>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => fn($model) => $this->render('item', [
                'model' => $model,
                'statuses' => $statuses,
                'status_order' => $status_order
            ]),
            'pager' => [
                'class' => LinkPager::class
            ],
        ]) ?>

        <?php Pjax::end(); ?>
    </div>

</div>