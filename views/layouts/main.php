<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\models\Cart;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\VarDumper;
use yii\widgets\Pjax;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => '<img src="/web/img/logo.JPG" alt="Логотип" class="logo"> Вкусная Доставка',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark fixed-top navbar-bg']
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Каталог', 'url' => ['/catalog']],
                Yii::$app->user->isGuest
                    ? ['label' => 'Регистрация', 'url' => ['/site/register']]
                    : '',

                // !Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin
                Yii::$app->user->identity?->isClient
                    ? ['label' => 'Личный кабинет', 'url' => ['/account']]
                    : '',


                Yii::$app->user->identity?->isAdmin
                    ? ['label' => 'Панель администратора', 'url' => ['/admin']]
                    : '',

                Yii::$app->user->identity?->isCourier
                    ? ['label' => 'Панель курьера', 'url' => ['/courier']]
                    : '',

                Yii::$app->user->isGuest
                    ? ['label' => 'Вход', 'url' => ['/site/login']]
                    : '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Выход (' . Yii::$app->user->identity->login . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
            ]
        ]);
        ?>
        <div>
            <?php 
            $isCartPage = Yii::$app->controller->module && 
                          Yii::$app->controller->module->id === 'account' && 
                          Yii::$app->controller->id === 'cart';
            if (Yii::$app->user->identity?->isClient && !$isCartPage): ?>
                <div class="d-flex">
                    <?= Html::a('<i class="fas fa-shopping-basket text-white"></i>', '/account/cart') ?>
                    <div class="mx-2 text-white">(<span id="cart-items-count"><?= Cart::getCount() ?></span>)
                    </div>
                </div>
            <?php endif ?>

        </div>
        <?php
        NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-4 footer-bg pt-5">
        <div class="container">
            <div class="row text-center justify-content-center gap-3">
                <div class="d-flex justify-content-beetween align-items-center">
                    <div class="d-flex gap-4 mess">
                        <img src="/web/img/vk2.png">
                        <img src="/web/img/od2.png">
                        <img src="/web/img/tg2.png">
                    </div>
                </div>
                <div class="col-md-6 text-center pt-3 border-top border-light ">&copy; Вкусная Доставка <?= date('Y') ?></div>
            </div>
        </div>
    </footer>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>