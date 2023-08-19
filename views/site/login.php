<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/user.png']);
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- <div class="col-md-4"></div> -->
<div class="site-login">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    

    <p>Введите логин и пароль, чтобы войти:</p>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div>{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
<!--    --><?php //echo Yii::$app->getSecurity()->generatePasswordHash(123456);?>
</div>

<?php 
    $this->registerCssFile('@web/css/login.css');
?>