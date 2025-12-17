<?php

use yii\bootstrap5\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$time_order = Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s');

$this->title = "Заказ №" . $model->id . " от " . $time_order;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('К заказам', ['/courier'], ['class' => 'btn btn-outline-primary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'created_at',
                'value' => $time_order,
            ],
            [
                'label' => 'Имя',
                'value' => $model->user->name,
            ],
            [
                'label' => 'Фамилия',
                'value' => $model->user->surname,
            ],
            [
                'label' => 'Отчество',
                'format' => 'html',
                'value' =>  $model->user->patronymic != null ? nl2br($model->user->patronymic) : "",
                'visible' => $model->user->patronymic != null,
            ],

            'amount',
            'sum',
            // [
            //     'attribute' => 'status_id',
            //     'format' => 'html',
            //     'value' => "<span class=\"order-status order-{$model->status->alias}\">"
            //         . $model->status->title
            //         . '</span>'
            //         . ($model?->reasonCancel
            //             ? "(заказ отменил: {$model->reasonCancel->user->full_name})"
            //             : ""
            //         ),
            // ],
            // [
            //     'label' => 'Причина отмены заказа',
            //     'format' => 'html',
            //     'value' =>  $model?->reasonCancel ? nl2br($model?->reasonCancel?->comment) : "",
            //     'visible' => (bool)$model?->reasonCancel
            // ],
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
