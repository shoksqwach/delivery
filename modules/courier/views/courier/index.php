<?php

use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\OrderSerach $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Панель курьера';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <div class="mt-5">

        <?php Pjax::begin(); ?>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => fn($model) => $this->render('item', [
                'model' => $model,
            ]),
            'pager' => [
                'class' => LinkPager::class
            ],
        ]) ?>

        <?php Pjax::end(); ?>
    </div>

</div>