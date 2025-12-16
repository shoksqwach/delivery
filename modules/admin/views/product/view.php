<?php

use app\models\Category;
use yii\bootstrap5\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',


            'cost',
            'amount',
            [
                'attribute' => 'category_id',
                'value' => Category::getCategories()[$model->category_id]
            ],
            [
                'label' => 'Изображение товара',
                'format' => 'html',
                'value' => Html::img('/img/' . $model->productImage->photo, ['class' => 'w-25'])
            ],
            [
                'attribute' => "description",
                "format" => "html",
                "value" => $model->description,
            ]

        ],
    ]) ?>

</div>