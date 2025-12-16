<?php

use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\Order $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-form">

    <div>
        <div class="mt-5 mb-2 row justify-content-between border-bottom px-3">
            <div class="col-9">Наименование товара</div>
            <div class="d-flex justify-content-between col-2">
                <div>кол-во</div>
                <div>цена</div>
                <div>сумма</div>
            </div>
        </div>
        <?= ListView::widget([
            'dataProvider' => $dataProviderItems,
            'itemOptions' => ['class' => 'item'],
            // для элементов корзины используем шаблон item-order (CartItem)
            'itemView' => 'item-order',
            'pager' => [
                'class' => LinkPager::class
            ],
        ]) ?>

        <div class=" d-flex justify-content-end border-bottom mt-2 text-secondary">
            <div class="d-flex justify-content-between col-2">
                <div>кол-во</div>
                <div>сумма</div>
            </div>
        </div>
        <div class=" d-flex justify-content-end mt-1 mb-5">
            <div class="d-flex justify-content-between col-2 fw-bold">
                <div><?= $cart->amount ?></div>
                <div><?= $cart->sum ?></div>
            </div>
        </div>

    </div>
    <div class="d-flex gap-3 justify-content-between">
        <?= Html::a('Продолжить покупки', ['/catalog'], ['class' => 'btn btn-outline-info', 'data-pjax' => 0]) ?>
        <?= Html::a('Оформить заказ', ['create', 'cart_id' => $cart->id], ['class' => 'btn btn-outline-primary', 'data-method' => 'post']) ?>
    </div>



</div>