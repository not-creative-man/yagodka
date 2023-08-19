<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 09/09/2019
 * Time: 22:00
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

$this->title = "Добавить баллы за собрание";
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

    echo $form->field($model, 'members')->widget(Select2::classname(), [
        'data' => $users,
        'options' => ['placeholder' => 'Выберите участников', 'multiple' => true],
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