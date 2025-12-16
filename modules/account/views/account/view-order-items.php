<?php

use yii\widgets\ListView;
?>
<div class="mt-5 mb-2 row justify-content-between border-bottom px-3">
    <div class="col-9">Наименование товара</div>
    <div class="col-3 d-flex gap-5">
        <div>кол-во</div>
        <div>цена</div>
        <div>сумма</div>
    </div>
</div>
<?= ListView::widget(
    [
        'dataProvider' => $dataProviderItems,
        'itemOptions' => ['class' => 'item'],
        'layout' => "{items}",
        'itemView' => 'item-order'
    ],
)

?>