<?php

use yii\bootstrap5\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\CatalogSerach $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Каталог товаров';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h3><?= Html::encode($this->title) ?></h3>


    <?php Pjax::begin([
        'id' => 'catalog-pjax',
        'enablePushState' => false,
        'timeout' => 5000
    ]); ?>


    <div class="d-flex align-items-end justify-content-between">
        <div class="mb-3">
            <?= $dataProvider->sort->link('cost') ?> |
            <?= $dataProvider->sort->link('title') ?>

        </div>
        <div>
            <?php echo $this->render('_search', ['model' => $searchModel]);  ?>
        </div>
    </div>



    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'layout' => '{pager}<div class="d-flex  flex-wrap justify-content-between gap-3">{items}</div>{pager}',
        'itemView' => 'item',

    ]) ?>

    <?php Pjax::end(); ?>

</div>
<?php
$this->registerJsFile('/js/catalog.js', ['depends' => 'yii\web\YiiAsset']);
