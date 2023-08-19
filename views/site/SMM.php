<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 10/09/2019
 * Time: 13:12
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

$this->title = "Добавить баллы за SMM";
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
    echo $form->field($model, 'type')->dropDownList(\app\models\SMMForm::$post_types);
    echo $form->field($model, 'link')->textInput();
    echo $form->field($model, 'user_id')->widget(Select2::classname(), [
        'data' => $users,
        'options' => ['placeholder' => 'Выберите участников', 'multiple' => false],
        'pluginOptions' => [
            'allowClear' => false,
        ],
    ]);

    echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'register-button']);

    ActiveForm::end();
    ?>
    </div>
    
    </div>
    


<?php 
    $this->registerCssFile('@web/css/new.css');
?>