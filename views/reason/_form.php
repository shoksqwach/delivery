<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ReasonCancel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reason-cancel-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>



    <div class="form-group d-flex justify-content-end gap-3">
        <?= Html::submitButton('Отменить заказ', ['class' => 'btn btn-outline-danger']) ?>
        <?= Html::a(
            'Закрыть',
            [
                Yii::$app->user->identity->isAdmin
                    ? "/admin"
                    : "/account"
            ],
            ['class' => 'btn btn-outline-primary']
        )
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>