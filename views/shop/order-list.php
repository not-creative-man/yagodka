<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 18/06/2019
 * Time: 17:52
 */

use app\models\Order;
use app\models\Product;
use app\models\User;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

$this->title = 'Заказы';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/logo.png']);
?>

<div class='page-header userdata'>
    <h1><?=$this->title?></h1>
</div>




<div class="panel panel-default panel-orderlist">
    <!-- Default panel contents -->
    <!-- Table -->
    <div class="panel-wrapper-table">
        <div class="header-line line">
            <div class="tab-1-header tab-1"><span>Товар   </span></div>
            <div class="tab-2"><span>Стоимость</span></div>
            <div class="tab-3"><span>Заказчик      </span></div>
            <div class="tab-4"><span>Статус      </span></div>
            <div class="tab-5-header tab-5"></div>
        </div>
        <?php foreach ($orders as $item): ?>
            <div class="line">
                <div class="tab-1">
                    <span class="name">
                        <?php 
                            $product = Product::findOne(["id" => $item->product_id]);
                            echo $product->name;
                        ?>
                    </span>
                </div>
                <div class="tab-2">
                    <?php
                       $product = Product::findOne(["id" => $item->product_id]);
                       echo $product->cost.'<span class="glyphicon glyphicon-apple"></span>';
                    ?>
                    
                </div>
                <div class="tab-3">
                    <?php 
                        $user = User::findOne(["id" => $item->user_id]);
                        $link = Html::a($user->berry, ['/site/profile', 'uid' => $user->id], ['class' => 'berry-link']);
                        echo $link;
                    ?>
                </div>
                <div class="tab-4"><?= $model->status == Order::NEED_ATTENDANCE?"Необходима выдача":"Выдан"; ?></div>
                <div class="tab-5">
                    <?php 
                        if($item->status == Order::COMPLETE) echo '';
                        else{
                            echo Html::a('Выполнен', ['shop/complete-order', 'order_id' => $model->id], ['class' => 'btn btn-success']);
                            echo Html::a('Удалить', ['shop/delete-order', 'order_id' => $model->id], ['class' => 'btn btn-danger']);
                        }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>



