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


<div class='page-header userdata'>
    <h1><?=$this->title?></h1>
</div>

<?php if(!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MEMBER): ?>
    <div class="button-wrapper-events">
        <h1><?= Html::a('Добавить товар', ['shop/create-product'], ['class' => 'btn btn-success pull-right']) ?></h1>
    </div>
<?php endif; ?>


<div class="panel panel-default panel-productlist">
    <!-- Default panel contents -->
    <!-- Table -->
    <div class="panel-wrapper-table">
        <div class="header-line line">
            <div class="tab-1-header tab-1"><span>Название   </span></div>
            <div class="tab-2"><span>Размеры</span></div>
            <div class="tab-3"><span>Цвета      </span></div>
            <div class="tab-4"><span>Статус      </span></div>
            <div class="tab-5"><span>Стоимость      </span></div>
            <div class="tab-6-header tab-6"><span>      </span></div>
        </div>
        <?php foreach ($product_list as $item): ?>
            <div class="line">
                <div class="tab-1"><span class="name"><?= $item->name ?>  </span></div>
                <div class="tab-2">
                    
                        <?php
                            $sizes = $item->size; 
                            if (!$sizes) echo "Размеры не заданы";
                            else {
                                $size_list = json_decode($sizes)->size;
                                $color_squares = "";
                                foreach ($size_list as $size){
                                    $color_squares .= "<a href='#' class='btn btn-primary' role='button' style='background-color: #9c5685; border-color: #9c5685'>$size</a> ";
                                }
                                echo "<div>$color_squares</div>";
                            }
                        ?>
                    
                </div>
                <div class="tab-3">
                        <?php 
                            $colors = $item->color;
                            if (!$colors) echo "Цвета не заданы";
                            else {
                                $color_list = json_decode($colors)->color;
                                $color_squares = "";
                                foreach ($color_list as $color){
                                    $color_squares .= "<a href='#' class='btn btn-primary' role='button' style='background-color: $color; border-color: $color; color: $color;'>M</a> ";
                                }
                                echo "<div>$color_squares</div>";
                            }
                        ?>
                </div>
                <div class="tab-4"><?= $item->active?"Доступен для покупки":"Недоступен для покупки"; ?></div>
                <div class="tab-5"><div><?= $item->cost.'<span class="glyphicon glyphicon-apple"></span>'; ?></div></div>
                <div class="tab-6">
                    <?php 
                        echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['shop/update-product', 'product_id' => $item->id]);
                        if($item->active)
                            echo Html::a('<span class="glyphicon glyphicon-eye-close"></span>', ['shop/disable-product', 'product_id' => $item->id]);
                        else 
                            echo Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['shop/enable-product', 'product_id' => $item->id]);
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php 
    $this->registerCssFile('@web/css/product-list.css');
?>