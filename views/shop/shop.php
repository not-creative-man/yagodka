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

<div class="page-header">
    <h1 class="mb20">
        <?= Html::encode('Магазин "ЗаЯБалл"') ?>
    </h1>
</div>
<div class="row">
<?php foreach ($product as $item): ?>
<?php $img_path = Product::productAvatar($item); ?>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="<?= $img_path ?>" alt="<?= $item->name ?> фото">
      <div class="caption">
        <h3><?= $item->name ?></h3>
        <?php if($item->size): ?>
        <?php $size_list = json_decode($item->size)->size ?>
        <p><b>Размеры:</b></p>
        <div>
            <?php foreach ($size_list as $size): ?>
            <a href="#" class="btn btn-primary" role="button" style="background-color: #9c5685; border-color: #9c5685">
                <?= $size ?>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

          <?php if($item->color): ?>
              <?php $color_list = json_decode($item->color)->color ?>
              <p style="margin-top: 10px"><b>Цвета:</b></p>
              <div>
                  <?php foreach ($color_list as $color): ?>
                      <a href="#" class="btn btn-primary" role="button" style="background-color: <?= $color ?>; border-color: <?= $color ?>; color: <?= $color ?>;">
                          M
                      </a>
                  <?php endforeach; ?>
              </div>
          <?php endif; ?>
          <div class="btn-group" style="margin-top: 10px">
              <?= Html::a("Купить", ["/shop/create-order", "product_id" => $item->id], ['class' => "btn btn-success", 'style' => "background-color: #9c5685; border-color: #9c5685"])?>
              <a href="#"  class="btn btn-primary" style="background-color: #904879; border-color: #904879"><?= $item->cost ?><span class="glyphicon glyphicon-apple"></span></a>
          </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
