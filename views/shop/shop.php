<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 26/06/2019
 * Time: 18:18
 */

use app\models\Product;
use yii\helpers\Html;


$this->title = 'ЗаЯБалл';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/members.png']);
?>

<style>
    .fa-custom-top{
        background-image: url(<?='../web/files/icons/starIcon.png'?>);
        width: 35px;
        height: 35px;
    }

    .fa-custom-berry{
        background: url(../web/files/icons/berriesIcon.png) 10% 10%;
        background-size: 95%;
        width: 25px;
        height: 22px;
    }

    .fa-custom-phone{
        background-image: url(<?='../web/files/icons/phone.png'?>);
        width: 35px;
        height: 35px;
    }

    .fa-custom-vk{
        background-image: url(<?='../web/files/icons/vk-black.png'?>);
        width: 35px;
        height: 35px;
    }

    .fa-custom-birth{
        background-image: url(<?='../web/files/icons/birthIcon.png'?>);
        width: 35px;
        height: 35px;
    }
</style>

<div class="page-header">
    <h1 class="mb20">
        <?= Html::encode('ЗаЯбалл') ?>
    </h1>
</div>
<div class="panel panel-shop">
<?php foreach ($product as $item): ?>
<?php $img_path = Product::productAvatar($item); ?>
  <div class="product-card">
    <div class="product-card-wrapper">
        
        <div class="product-card-image-wrapper">
            <img src="./files/products/1628090969.jpg" alt="<?= $item->name ?> фото"> 
            <!-- <img src="<?= $img_path ?>" alt="<?= $item->name ?> фото"> -->
        </div>
        <div class="caption">
            <div class="tab-1">
                <h3><?= $item->name ?></h3>
            </div>
            <div class="tab-2">
                <?php if($item->size): ?>
                    <?php $size_list = json_decode($item->size)->size ?>
                    <div class="tab-2-2">
                        <p><b>Размер:</b></p>
                    </div>
                    <div class="tab-2-4">
                        <?php foreach ($size_list as $size): ?>
                        <a href="#" class="btn btn-primary" role="button" >
                            <?= $size ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if($item->color): ?>
                    <?php $color_list = json_decode($item->color)->color ?>
                    <div class="tab-2-1">
                        <p><b>Цвет:</b></p>
                    </div>
                    <div class="tab-2-3">
                        <?php foreach ($color_list as $color): ?>
                            <a href="#" class="btn btn-primary" role="button" style="background-color: <?= $color ?>; border-color: <?= $color ?>; color: <?= $color ?>;">
                                M
                            </a>
                        <?php endforeach; ?>
                    </div>        
                <?php endif; ?>
            </div>
            
            <div class="tab-3">
                <h3><?= $item->cost ?> <i class="fa fa-custom-berry"></i></h3>
            </div>
            
            <div class="tab-6">
                <?= Html::a("купить", ["/shop/create-order", "product_id" => $item->id], ['class' => "btn btn-success"])?>
                <!-- <a href="#"  class="btn btn-primary" style="background-color: #904879; border-color: #904879"><?= $item->cost ?><span class="glyphicon glyphicon-apple"></span></a> -->
            </div>
        </div>
    </div>
  </div>
<?php endforeach; ?>
</div>


<?php 
    $this->registerCssFile('@web/css/shop.css');
?>