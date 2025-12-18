<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

$disabled = Yii::$app->user->isGuest || $model->amount === 0 ? 'disabled' : '';
$favourite_id = $model?->favourites ? $model?->favourites[0]?->id : false;
$favourite_color = $favourite_id
    ? "text-danger"
    : "text-black";

Yii::debug($model->like_count);
Yii::debug($model->dislike_count);

?>
<div class="card" style="width: 18rem;">
    <?= Html::a(Html::img('/img/' . $model->productImage->photo, ['class' => "card-img-top"]), ['view', 'id' => $model->id], ['class' => 'text-decoration-none text-secondary', 'data-pjax' => 0]) ?>
    <div class="card-body">
        <h5 class="card-title"><?= Html::a($model->title, ['view', 'id' => $model->id], ['class' => 'text-decoration-none text-secondary product-title', 'data-pjax' => 0]) ?></h5>
        <h6 class="card-subtitle mb-2 text-body-secondary"><span class="text-secondary">Категория:</span> <?= $model->category->title ?></h6>
        <p class="card-text fs-bold fs-5 text-end"><?= $model->cost ?><span>₽</span></p>
        <div class="d-flex justify-content-between my-2 block-icon">
            <div class="d-flex gap-3">

                <div class="text-success">
                    <span
                        class="<?= !Yii::$app->user->isGuest && Yii::$app->user->identity->isClient ? 'like' : 'disabled' ?>"
                        data-url="<?= !Yii::$app->user->isGuest && Yii::$app->user->identity->isClient
                                        ? Url::to(['user-action', 'product_id' => $model->id, 'action' => 1])
                                        : "" ?>"><img src="../../web/img/like.png" alt="like" class="dis-like"></span>
                    <?= $model->like_count ? $model->like_count : 0 ?>
                </div>
                <div class="text-danger">
                    <span
                        class="<?= !Yii::$app->user->isGuest && Yii::$app->user->identity->isClient ? 'dislike' : 'disabled' ?>"
                        data-url="<?= !Yii::$app->user->isGuest && Yii::$app->user->identity->isClient
                                        ? Url::to(['user-action', 'product_id' => $model->id, 'action' => 0])
                                        : "" ?>"><img src="../../web/img/dislike.png" alt="dislike" class="dis-like"></span>
                    <?= $model->dislike_count ? $model->dislike_count : 0 ?>
                </div>
            </div>
            <div>
                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isClient): ?>
                    <i
                        class="far fa-heart icon-favourite <?= $favourite_color ?>"
                        data-url="<?= $favourite_id
                                        ? Url::to(['/account/favourite/remove', 'id' => $favourite_id])
                                        : Url::to(['/account/favourite/add', 'product_id' => $model->id]) ?>">
                    </i>
                <?php endif ?>
            </div>



        </div>
        <div>
            <?php if (Yii::$app->user->identity?->isClient): ?>
                <?= Html::a('В корзину', ['/account/cart/add', 'product_id' => $model->id], ['class' => "btn btn-outline-primary w-100 $disabled  btn-cart-add", 'data-pjax' => 0]) ?>
            <?php endif ?>
        </div>
    </div>
</div>