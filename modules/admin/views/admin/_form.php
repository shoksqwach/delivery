<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
?>
<div class="site-contact">
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <?= $form->field($model, 'courier_id')->dropDownList(User::getCouriers(), ['prompt' => 'Выберите курьера']) ?>

            <div class="form-group">
                <?= Html::submitButton('Назначить', ['class' => 'btn btn-outline-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>