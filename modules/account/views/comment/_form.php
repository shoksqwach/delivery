<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Feedback $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-feedback',
        'action' => '/account/comment/write?product_id=' . $model->product_id,
        'options' => [
            'data-pjax' => true
        ]
    ]); ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div class="form-group d-flex justify-content-end gap-3">
        <?= Html::a('Отменить', [""], ['class' => 'btn btn-outline-primary btn-cancel', "data-pjax" => 0]) ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>