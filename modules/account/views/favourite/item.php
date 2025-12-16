<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;


$favourite_id = $model->id;
$favourite_color = "text-danger";

?>
<div class="card" style="max-width: 18rem;">
    <?= Html::a(Html::img('/img/' . $model->product->productImage->photo, ['class' => "card-img-top", "style" => "min-height: 215px"]), ['view', 'id' => $model->id], ['class' => 'text-decoration-none text-secondary', 'data-pjax' => 0]) ?>
    <div class="card-body">
        <h5 class="card-title"><?= Html::a($model->product->title, ['view', 'id' => $model->product->id], ['class' => 'text-decoration-none text-secondary product-title', 'data-pjax' => 0]) ?></h5>
        <h6 class="card-subtitle mb-2 text-body-secondary"><span class="text-secondary">Категория:</span> <?= $model->product->category->title ?></h6>
        <p class="card-text fs-bold fs-5 text-end"><?= $model->product->cost ?><span>₽</span></p>
        <div class="d-flex justify-content-between my-2 block-icon">
            <div>

            </div>
            <div>
                <i
                    class="far fa-heart icon-favourite <?= $favourite_color ?>"
                    data-url="<?= Url::to(['/account/favourite/remove', 'id' => $favourite_id]) ?>">
                </i>
            </div>

        </div>
        <?= Html::a('В корзину', ['/account/cart/add', 'product_id' => $model->id], ['class' => "btn btn-outline-primary w-100 btn-cart-add", 'data-pjax' => 0]) ?>
    </div>
</div>