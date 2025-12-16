<?php

use app\models\Cart;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;
$cartNoEmpty = $cart && $dataProviderItems->totalCount;
?>
<div class="cart-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php Pjax::begin([
        'id' => 'cart-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]); ?>
    <?php if ($dataProviderItems->totalCount): ?>
        <?= ListView::widget([
            'dataProvider' => $dataProviderItems,
            'itemOptions' => ['class' => 'item'],
            'itemView' => 'item',
            'pager' => [
                'class' => LinkPager::class
            ],
        ]) ?>
    <?php else: ?>
        <div class="alert alert-info" role="alert">
            В корзине пока нет товаров
        </div>


    <?php endif ?>

    <div class="d-flex justify-content-between mt-3">
        <div>
            <?= $cartNoEmpty
                ? Html::a('Очистить корзину', ['clear', 'id' => $cart->id], ['class' => 'btn btn-outline-danger cart-btn'])
                : ""
            ?>
        </div>
        <div class="d-flex gap-3">
            <?= $cartNoEmpty
                ? Html::a('Оформить заказ', ['/account/account/create', 'cart_id' => $cart->id], ['class' => 'btn btn-outline-primary'])
                : ""
            ?>
            <?= Html::a('Продолжить покупки', ['/'], ['class' => 'btn btn-outline-info', 'data-pjax' => 0]) ?>
        </div>
    </div>
    <?php Pjax::end(); ?>

</div>
<?php
$this->registerJsFile('/js/cart.js', ['depends' => 'yii\web\YiiAsset']);
