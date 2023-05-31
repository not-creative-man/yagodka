<?php

/* @var $this yii\web\View */

use app\models\User;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;

$this->title = 'Ягодка';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/logo.png']);
?>

<style>
    .back{
        position: absolute;
        width: 100vw;
        height: 712px;
        left: 0;
        background: url('files/icons/worm-1.svg') no-repeat top 20px left -130px,
                    url('files/icons/worm-3.svg') no-repeat top 457px left -130px,
                    url('files/icons/worm-2.svg') no-repeat top 326px left -93px,
                    
                    url('files/icons/worm-4.svg') no-repeat top 6px right -150px,
                    url('files/icons/worm-6.svg') no-repeat top 484px right -116px,
                    url('files/icons/worm-5.svg') no-repeat top 392px right -152px;
    }
</style>
<div class="site-index">
    <div class="label-part">
        <div class="background-image"></div>
        <div class="label-part-wrapper">
            <div class="label-header">
                <div class="not-jumbotron">
                    <h1 class="on-violet">самый сочный<br>студенческий клуб</h1>
                </div>
                <?= Html::img('@web/files/icons/logotype-big-1.svg', ['alt' => 'Logo', 'class' => 'big-label']) ?>
            </div>
            <div class="label-circles">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stat">
                            <?= Html::img('@web/files/icons/circle-1.svg', ['class'=>'circle']); ?>
                            <div class="stat-text text-center">
                                <span class="statistic"> <?= $total_coverage ?> </span><br/>
                                <span class="statistic-label">общий<br>охват людей</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat">
                            <?= Html::img('@web/files/icons/circle-1.svg', ['class'=>'circle']); ?>
                            <div class="stat-text text-center">
                                <span class="statistic"> <?= $event_count ?> </span><br/>
                                <span class="statistic-label">мероприятий<br>клуба</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat">
                            <?= Html::img('@web/files/icons/circle-1.svg', ['class'=>'circle']); ?>
                            <div class="stat-text text-center">
                                <span class="statistic"> <?= $member_count ?> </span><br/>
                                <span class="statistic-label">участников<br>в клубе</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="description">
        <div class="description-body">
            <div class="back"></div>
            <div class="description-text">
                <p class="main-description-header">Ягодка - компот студентов,<br/> который занимается деятельностью<br/>на базе УСОЦ «Ягодное» :</p>
                <ul>
                    <li>Организация мероприятий </li>
                    <li>Реализация и поддержка инициатив студентов </li>
                    <li>Развитие инфраструктуры лагеря</li>
                    <li>Развитие информационного пространства </li>
                    <li>Развитие и поддержка внутренней культуры и традиций клуба</li>
                </ul>
            </div> 
        </div>
    </div>    

    

    <?php if(Yii::$app->user->isGuest) :?>
        <div class="join-us">
            <div class="background-image-join"></div>
            <div class="join-us-wrapper">
                <div class="join-us-wrapper-top">
                    <?= Html::img('@web/files/icons/arrow-left.png', ['class'=> 'left-arrow arrow']); ?>
                    <p class="lead-text">Хотите вступить?</p>
                    <?= Html::img('@web/files/icons/arrow-right.png', ['class'=> 'right-arrow arrow']); ?>
                </div>
                <div class="button-wrapper">
                    <a class="btn btn-reg" href="https://vk.com/@yagodka_club-reglament">Как вступить?</a>

                        <?php
                        Modal::begin([
                            'header' => '<h2>регистрация</h2>',
                            'toggleButton' => [
                                'label' => 'Регистрация',
                                'tag' => 'button',
                                'class' => 'btn btn-reg',
                            ],
                        ]);
                    ?>

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]); ?>
                    <?= $form->field($model, 'password')->passwordInput(); ?>
                    <?= $form->field($model, 'password_repeat')->passwordInput(); ?>
                    <?= $form->field($model, 'name')->textInput(); ?>
                    <?= $form->field($model, 'surname')->textInput(); ?>
                    <?= $form->field($model, 'patronymic')->textInput(); ?>
                    <?= $form->field($model, 'isu')->textInput()->label("<i class=\"far fa-address-card\"></i> Табельный номер ИСУ"); ?>
                    <?= $form->field($model, 'birth')->textInput(); ?>
                    <?= $form->field($model, 'berry')->textInput(); ?>
                    <?= $form->field($model, 'phone')->textInput(['autofocus' => true])->label("<i class='fas fa-phone'></i> Номер телефона") ?>
                    <?= $form->field($model, 'vk')->textInput()->label("<i class=\"fab fa-vk\"></i> Ссылка ВК") ?>
                    <?= Html::submitButton('Применить' ,['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

                    <?php ActiveForm::end(); ?>

                    <?php Modal::end() ?>
                </div>

            </div>
            
            
        
            
        </div>
    <?php endif; ?>
    <?= Html::a('Регистер', ['/site/register'], ['class'=>'btn btn-lg btn-info', 'style' => 'display: none;']); ?>

    
</div>


<?php
    $this->registerCssFile('@web/css/index.css');
?>