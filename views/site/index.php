<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Вкусная Доставка</h1>
        <p class="lead">Продукты премиум-качества с доставкой на дом</p>
    </div>

       <div class="body-content text-center">

        <div class="row">
            <div class="col-lg-4 mb-3 mb-5">
                <img src="/web/img/eda1.jpg" alt="1" class="img-style mb-3">
                <h2>Качественные <br> продукты</h2>
            </div>
            <div class="col-lg-4 mb-3">
                <img src="/web/img/eda2.jpg" alt="1" class="img-style mb-3">
                <h2>Быстрая <br> доставка</h2>
            </div>
            <div class="col-lg-4">
                <img src="/web/img/eda3.jpg" alt="1" class="img-style mb-3">
                <h2>Удобные <br> цены</h2>
            </div>
        </div>

        <div class="row align-items-center">


                <div id="carouselExampleInterval" class="carousel slide carousel-fade mb-5" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="3000">
                            <img src="/web/img/1.jpg" class="d-block w-100" alt="1">
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="/web/img/2.jpg" class="d-block w-100" alt="2">
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="/web/img/3.jpg" class="d-block w-100" alt="3">
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="/web/img/4.jpg" class="d-block w-100" alt="4">
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="/web/img/5.jpg" class="d-block w-100" alt="5">
                        </div>
                    </div>
                    <button class="carousel-control-prev m-3" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Назад</span>
                    </button>
                    <button class="carousel-control-next m-3" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Вперед</span>
                    </button>
                </div>
            </div>


    </div>
</div>
