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

<div class="row">
    <div class='page-header'>
        <h1><?= $this->title ?></h1>
    </div>
    
</div>

<div class="panel panel-default panel-new">

    <div class="panel-wrapper-new">
        <?php
            $form = ActiveForm::begin();

            echo $form->field($model, 'name')->textInput(['autofocus' => true]);
            echo $form->field($model, 'task')->textInput();
            echo $form->field($model, 'cash')->textInput();
            echo $form->field($model, 'deadline')->textInput(['placeholder' => 'дд.мм.гггг']);
            echo $form->field($model, 'max_user')->textInput();

            echo Html::submitButton('сохранить изменения', ['class' => 'btn btn-red']);

            ActiveForm::end();
        ?>
    </div>
    
</div>

<?php 
    $this->registerCssFile('@web/css/new.css');
?>