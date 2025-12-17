<?php

use app\models\Category;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Html;
use yii\web\JqueryAsset;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Продукты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="product-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p class="d-flex gap-3">
        <?= Html::a('В каталог', ['/catalog'], ['class' => 'btn btn-outline-primary']) ?>
        <?= !$model?->comments
            ? Html::a('Отзыв', ['/account/comment/write', 'product_id' => $model->id], ['class' => 'btn btn-outline-info btn-feedback'])
            : ""
        ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'category_id',
                'value' => Category::getCategoryName($model->category_id),
            ],
            'cost',
            'amount',
            [
                'attribute' => 'description',
                'value' => $model->description ?? 'Не указано',
            ],
            [
                'label' => 'Изображение',
                'format' => 'html',
                'value' => Html::img('/img/' . $model->productImage->photo, ['class' => 'w-25'])
            ]

        ],
    ]) ?>

    <div class="my-3 text-decoration-underline">
        Отзывы о товаре
    </div>

    <?php Pjax::begin([
        'id' => 'product-comments-pjax',
        'enablePushState' => false,
        'timeout' => 5000
    ]); ?>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'layout' => '{pager}<div class="d-flex flex-column gap-3">{items}</div>{pager}',
        'itemView' => 'item_comment',
        'pager' => [
            'class' => LinkPager::class,
        ]
    ]) ?>

    <?php Pjax::end(); ?>


</div>
<?php
Modal::begin([
    'id' => 'modal-comment',
    'title' => 'Отзыв о товаре',
    'size' => Modal::SIZE_LARGE
]);


echo $this->render("@app/modules/account/views/comment/create", ['model' => $model_comment]);

Modal::end();

$this->registerJsFile("/js/comment.js", ['depends' => JqueryAsset::class]);
