<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 18/06/2019
 * Time: 17:52
 */

$this->title = 'Заказы';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/logo.png']);
?>

<div class="row">
    <div class='page-header clearfix' style="margin-top: 0;">
        <div class="col-md-6">
            <h1><?= $this->title ?></h1>
        </div>
    </div>
</div>

<?php

use app\models\Order;
use app\models\Product;
use app\models\User;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

$dataProvider = new ActiveDataProvider([
    'query' => $orders,
    'pagination' => [
        'pageSize' => 20,
    ],
]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => "Показано <b>{count}</b> заказов из <b>{totalCount}</b>",
    'columns' => [
        [
            'label' => 'Товар',
            'attribute' => 'product_id',
            'content' => function ($model, $key, $index, $column) {
                $product = Product::findOne(["id" => $model->product_id]);
                return $product->name;
            }
        ],
        [
            'label' => 'Стоимость',
            'content' => function ($model, $key, $index, $column) {
                $product = Product::findOne(["id" => $model->product_id]);
                return $product->cost.'<span class="glyphicon glyphicon-apple"></span>';
            }
        ],
        [
            'label' => 'Заказчик',
            'attribute' => 'user_id',
            'content' => function ($model, $key, $index, $column) {
                $user = User::findOne(["id" => $model->user_id]);
                $link = Html::a($user->berry, ['/site/profile', 'uid' => $user->id], ['class' => 'berry-link']);
                return $link;
            }
        ],
        [
            'label' => 'Статус',
            'attribute' => 'status',
            'content' => function ($model, $key, $index, $column) {
                return $model->status == Order::NEED_ATTENDANCE?"Необходима выдача":"Выдан";
            }
        ],
        [
            'class' => '\yii\grid\ActionColumn',
            'template' => '{complete} {delete}',
            'buttons' => [
                'complete' => function ($url, $model, $key) {
                    if ($model->status == Order::COMPLETE) return "";
                    return Html::a('Выполнен', ['shop/complete-order', 'order_id' => $model->id], ['class' => 'btn btn-success']);
                },
                'delete' => function ($url, $model, $key) {
                    if ($model->status == Order::COMPLETE) return "";
                    return Html::a('Удалить', ['shop/delete-order', 'order_id' => $model->id], ['class' => 'btn btn-danger']);
                }
            ]

        ],
    ]
]);
