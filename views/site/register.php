<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'placeholder' => 'Александр']) ?>

            <?= $form->field($model, 'surname')->textInput(['placeholder' => 'Александров']) ?>

            <?= $form->field($model, 'patronymic')->textInput(['placeholder' => 'Александрович (при наличии отчества)']) ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => 'example@mail.ru']) ?>

            <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
                'mask' => '+7(999)-999-99-99',
                'options' => [
                    'placeholder' => '+7(___)-___-__-__',
                ],
            ]) ?>

            <?= $form->field($model, 'login')->textInput(['placeholder' => 'alex']) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'fgd412']) ?>

            <?= $form->field($model, 'password_repeat')->passwordInput() ?>

            <?= $form->field($model, 'rules')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-outline-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>