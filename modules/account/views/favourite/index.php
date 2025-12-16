<?php

use app\models\Favourite;
use PHPUnit\Util\PHP\Job;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Избранные товары';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/account']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="favourite-index">

    <h3><?= Html::encode($this->title) ?></h3>


    <?php Pjax::begin([
        'id' => 'favourite-pjax',
        'timeout' => 5000
    ]); ?>
    <?= $this->render('_search', ['model' => $searchModel]);    ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'layout' => '{pager}<div class="d-flex  flex-wrap justify-content-start gap-3">{items}</div>{pager}',
        'itemView' => 'item',

    ]) ?>

    <?php Pjax::end(); ?>

</div>

<?php

$this->registerJsFile('/js/favourite.js', ['depends' => JqueryAsset::class]);
