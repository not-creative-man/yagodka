<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 10/04/2019
 * Time: 18:08
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;

$this->title = "Новая задача";
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/settings.png']);

?>

<div class="col-md-6 col-md-offset-3">

    <h1 class="mb20">
        <?= Html::encode($this->title) ?>
    </h1>

    <?php
    $form = ActiveForm::begin();

    echo $form->field($model, 'name')->textInput(['autofocus' => true]);
    echo $form->field($model, 'task')->textInput();
    echo $form->field($model, 'cash')->textInput();
    echo $form->field($model, 'deadline')->textInput(['placeholder' => 'дд.мм.гггг']);
    echo $form->field($model, 'max_user')->textInput();

    echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']);

    ActiveForm::end();
    ?>
</div>