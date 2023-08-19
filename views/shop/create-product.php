<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 25/07/2019
 * Time: 12:52
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = $title_text;
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/settings.png']);
?>


<div class="row">
    <div class='page-header'>
        <h1><?= $this->title ?></h1>
    </div>
    
</div>

<div class="panel panel-default panel-new">

    <div class="panel-wrapper-new">
        <?php
            $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
            $product_form->active = 1;
        ?>
            <?= $form->field($product_form, 'name')->textInput() ?>
            <?= $form->field($product_form, 'cost')->textInput() ?>
            <?= $form->field($product_form, 'size')->textInput(['placeholder' => "{\"size\":[\"M\",\"L\",\"XL\"]}"]) ?>
            <?= $form->field($product_form, 'color')->textInput(['placeholder' => "{\"color\":[\"orange\", \"red\", \"green\", \"blue\"]}"]) ?>
            <?= $form->field($product_form, 'active')->checkbox() ?>
            <?= $form->field($product_form, 'image')->fileInput() ?>
            <?= Html::submitButton($bottom_text, ['class' => 'btn btn-red', ]) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>



<?php 
    $this->registerCssFile('@web/css/new.css');
?>