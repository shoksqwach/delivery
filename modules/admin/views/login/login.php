<?php

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="d-flex flex-column justify-content-center align-items-center w-100  " style="margin-top: 25%">


        <div class="row w-25 border rounded ">
            <div class="col-12 p-3">
                <h3 class="text-center"><?= Html::encode($this->title) ?></h3>

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => ['class' => 'col-lg-7 col-form-label mr-lg-3'],
                        'inputOptions' => ['class' => 'col-lg-7 form-control'],
                        'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                    ],
                ]); ?>

                <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>



                <div class="form-group">
                    <div class="content-center ">
                        <?= Html::submitButton('Вход', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <div>
                Пользователи: admin/admin
            </div>
        </div>
    </div>

</div>