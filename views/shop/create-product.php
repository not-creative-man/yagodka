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
    <div class="page-header">
        <h1>
            <?= $title_text ?>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
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
            <?= Html::submitButton($bottom_text, ['class' => 'btn btn-success', ]) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>