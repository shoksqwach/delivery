<?php

use yii\bootstrap5\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$time_order = Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i');

$this->title = "Заказ №" . $model->id . " от " . $time_order;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('К заказам', ['/account'], ['class' => 'btn btn-outline-primary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'created_at',
                'value' => $time_order,
            ],

            'amount',
            'sum',
            [
                'attribute' => 'status_id',
                'format' => 'html',
                'value' => "<span class=\"order-status order-{$model->status->alias}\">"
                    . $model->status->title
                    . '</span>'
                // . ($model?->reasonCancel && $model?->reasonCancel->user_id !== Yii::$app->user->id
                //     ? "(заказ отменил: {$model->reasonCancel->user->full_name})"
                //     : ""
                // ),
            ],
            // [
            //     'label' => 'Причина отмены заказа',
            //     'format' => 'html',
            //     'value' =>  $model?->reasonCancel ? nl2br($model?->reasonCancel?->comment) : "",
            //     'visible' => (bool)$model?->reasonCancel
            // ],
            [
                'label' => 'Курьер',
                'format' => 'html',
                'value' => $model?->courier_id ? nl2br($model->courier->name . ' ' . $model->courier->surname) : 'Не назначен',
            ],
            [
                'label' => 'Просмотр заказа',
                'format' => 'html',
                'value' => $this->render('view-order-items', ['dataProviderItems' => $dataProviderItems,])
            ],
        ],
    ]) ?>

</div>
<?php

$this->registerCssFile('/css/order.css');
