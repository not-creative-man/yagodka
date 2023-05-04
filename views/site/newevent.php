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

$this->title = "Отчет о мероприятии";
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/settings.png']);
?>

<div class="col-md-6 col-md-offset-3">

    <h1 class="mb20">
        <?= Html::encode($this->title) ?>
    </h1>

    <?php
    $form = ActiveForm::begin();

    echo $form->field($model, 'name')->textInput(['autofocus' => true]);
    echo $form->field($model, 'date')->textInput(['placeholder' => 'дд.мм.гггг']);
    echo $form->field($model, 'place')->textInput();
    echo $form->field($model, 'description')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'basic',
            'inline' => false,
        ],
    ]);

    echo $form->field($model, 'program')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'basic',
            'inline' => false,
        ],
    ]);

    echo $form->field($model, 'links')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'small',
            'inline' => false,
        ],
    ]);

    echo $form->field($model, 'linksmedia')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'small',
            'inline' => false,
        ],
    ]);

    echo $form->field($model, 'level')->dropDownList(
        \app\models\Event::$event_levels
    );
    echo $form->field($model, 'coverage')->textInput();
    echo $form->field($model, 'org')->textInput();
    echo $form->field($model, 'cluborg')->textInput();

    echo $form->field($model, 'mainorg')->widget(Select2::classname(), [
        'data' => $users,
        'options' => ['placeholder' => 'Выберите главного организатора', 'multiple' => false, 'required'],
        'pluginOptions' => [
            'allowClear' => false,
        ],
    ]);
    echo $form->field($model, 'curator')->widget(Select2::classname(), [
        'data' => $curators,
        'options' => ['placeholder' => 'Выберите куратора мероприятия', 'multiple' => false],
        'pluginOptions' => [
            'allowClear' => false,
        ],
    ]);

    echo $form->field($model, 'orgs')->widget(Select2::classname(), [
        'data' => $users,
        'options' => ['placeholder' => 'Выберите организаторов', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => false,
        ],
    ]);

    echo $form->field($model, 'responsible')->widget(Select2::classname(), [
        'data' => $users,
        'options' => ['placeholder' => 'Выберите ответственных исполнителей', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => false,
        ],
    ]);

    echo $form->field($model, 'volunteer')->widget(Select2::classname(), [
        'data' => $users,
        'options' => ['placeholder' => 'Выберите волонтеров', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => false,
        ],
    ]);

    echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'register-button']);

    ActiveForm::end();
    ?>
</div>