<?php

use app\models\Order;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\account\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h3 class="mb-5"><?= Html::encode($this->title) ?></h3>

    <div class="my-3">
        <?= Html::a('Избранное', '/account/favourite', ['class' => "btn btn-outline-primary"]) ?>
        <?= Html::a('Мои отзывы', '/account/comment/view', ['class' => "btn btn-outline-primary"]) ?>
    </div>

    <?php Pjax::begin(); ?>
    <?php # $this->render('_search', ['model' => $searchModel]); 
    ?>

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

<?php
$this->registerCssFile("/css/order.css");
