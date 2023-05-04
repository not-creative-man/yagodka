<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 18/06/2019
 * Time: 17:52
 */

use app\models\Product;
use app\models\User;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

$this->title = 'Товары';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/settings.png']);
?>

<div class="row">
    <div class='page-header clearfix' style="margin-top: 0;">
        <div class="col-md-6">
            <h1><?= $this->title ?></h1>
        </div>
        <?php if(!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MEMBER): ?>
            <div class="col-md-6">
                <h1><?= Html::a('Добавить товар', ['shop/create-product'], ['class' => 'btn btn-success pull-right']) ?></h1>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php

$dataProvider = new ActiveDataProvider([
    'query' => Product::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => "Показано <b>{count}</b> товаров из <b>{totalCount}</b>",
    'columns' => [
        [
            'label' => 'Название',
            'attribute' => 'name'
        ],
        [
            'label' => 'Размеры',
            'attribute' => 'size',
            'content' => function ($model, $key, $index, $column) {
                if (!$model->size) return "Размеры не заданы";
                $size_list = json_decode($model->size)->size;
                $color_squares = "";
                foreach ($size_list as $size){
                    $color_squares .= "<a href='#' class='btn btn-primary' role='button' style='background-color: #9c5685; border-color: #9c5685'>$size</a> ";
                }
                $color_view = "<div>$color_squares</div>";
                return $color_view;
            }
        ],
        [
            'label' => 'Цвета',
            'attribute' => 'color',
            'content' => function ($model, $key, $index, $column) {
                if (!$model->color) return "Цвета не заданы";
                $color_list = json_decode($model->color)->color;
                $color_squares = "";
                foreach ($color_list as $color){
                    $color_squares .= "<a href='#' class='btn btn-primary' role='button' style='background-color: $color; border-color: $color; color: $color;'>M</a> ";
                }
                $color_view = "<div>$color_squares</div>";
                return $color_view;
            }
        ],
        [
            'label' => 'Статус',
            'attribute' => 'active',
            'content' => function ($model, $key, $index, $column) {
                return $model->active?"Доступен для покупки":"Недоступен для покупки";
            }
        ],
        [
            'label' => 'Стоимость',
            'attribute' => 'active',
            'content' => function ($model, $key, $index, $column) {
                return $model->cost.'<span class="glyphicon glyphicon-apple"></span>';
            }
        ],
        [
            'class' => '\yii\grid\ActionColumn',
            'template' => '{update} {disable} {enable}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['shop/update-product', 'product_id' => $model->id]);
                },
                'disable' => function ($url, $model, $key) {
                    if (!$model->active) return "";
                    return Html::a('<span class="glyphicon glyphicon-eye-close"></span>', ['shop/disable-product', 'product_id' => $model->id]);
                },
                'enable' => function ($url, $model, $key) {
                    if ($model->active) return "";
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['shop/enable-product', 'product_id' => $model->id]);
                }
            ]
        ],
    ]
]);