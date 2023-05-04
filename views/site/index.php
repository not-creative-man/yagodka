<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
$this->title = 'Ягодка';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/logo.png']);
?>
<style>
    .stat {
        height: 25vh;
        width: 25vh;
        /* background-color: indianred; */
        color: white;
        /* border-radius: 50%; */
        font-size: 8vh;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 15px;
        background-image: url('../../web/files/icons/circle-1.svg');
        background-repeat: no-repeat;
    }

    .stat-text {
        position: relative;
        top: 60px;
        right: 60px;
        display: flex;
        flex-direction: column;
    }

    .stat-text > span{
        font-family: "Montserrat";
        font-style: normal;
        font-weight: 700;
        font-size: 15px;
        line-height: 18px;
        text-align: right;    
    }

    .sn-icon {
        height: 5vh;
        margin-left: auto;
        margin-right: auto;
    }

    .sn-icons-row {
        text-align: center;
    }

    .list3b {
        padding:0;
        list-style: none;
        counter-reset: li;
    }
    .list3b li {
        position: relative;
        border-left: 4px solid #DDDDDD;
        padding:16px 20px 16px 28px;
        margin:12px 0 12px 80px;
        -webkit-transition-duration: 0.3s;
        transition-duration: 0.3s;
    }
    .list3b li:before {
        line-height: 32px;
        position: absolute;
        top: 10px;
        left:-80px;
        width:80px;
        text-align:center;
        font-size: 24px;
        font-weight: bold;
        color: #DDDDDD;
        counter-increment: li;
        content: counter(li);
        -webkit-transition-duration: 0.3s;
        transition-duration: 0.3s;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .list3b li:hover:before {
        color: #77AEDB;
    }
    .list3b li:after {
        position: absolute;
        top: 26px;
        left: -40px;
        width: 60px;
        height: 60px;
        border: 8px solid #3399FF;
        border-radius: 50%;
        content: '';
        opacity: 0;
        -webkit-transition: -webkit-transform 0.3s, opacity 0.3s;
        -moz-transition: -moz-transform 0.3s, opacity 0.3s;
        transition: transform 0.3s, opacity 0.3s;
        -webkit-transform: translateX(-50%) translateY(-50%) scale(0.1);
        -moz-transform: translateX(-50%) translateY(-50%) scale(0.1);
        transform: translateX(-50%) translateY(-50%) scale(0.1);
        pointer-events: none;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .list3b li:hover:after {
        opacity: 0.2;
        -webkit-transform: translateX(-50%) translateY(-50%) scale(1);
        -moz-transform: translateX(-50%) translateY(-50%) scale(1);
        transform: translateX(-50%) translateY(-50%) scale(1);
    }

    .description {
        margin-top: 3vh;
        font-size: medium;
    }

    .label-part{
        background-color: var(--main-violet-color);
        height: 845px;
        display: flex;
        align-items: center;
    justify-content: center;
    }

    .label-header{
        display: flex;
        align-items: flex-end;
        margin-bottom: 100px; 
    }

    .on-violet{
        color: var(--main-white-color) !important;
        margin: 0 56px 0 0;
    }

    .big-label{
        width: 250px;
    }

    .statistic{
        font-family: "Comic Neue" !important;
        font-style: normal!important;
        font-weight: 700 !important;
        font-size: 40px !important;
        line-height: 46px !important;
        margin-bottom: 10px !important;
    }

    .description-body{
        max-width: 1440px;
        margin: 0 auto;
    }

    .worm{
        position: absolute;
    }

    .worm-1{
        width: 270.22px;
        height: 192.42px;
        /* left: -196px; */
        top: 1049.93px;
        transform: rotate(-18.32deg);
    }

    .worm-2{
        width: 186.01px;
        height: 153.74px;
        /* left: -60.42px; */
        top: 1271px;
        transform: rotate(12.23deg);
    }

    .worm-3{
        width: 212.68px;
        height: 151.1px;
        left: -130px;
        top: 1504.23px;
        transform: rotate(-28.73deg);
    }

    .worm-4{
        width: 293.71px;
        height: 209.24px;
        left: 1296.16px;
        top: 951px;
    }

    .worm-5{
        width: 294.95px;
        height: 257.17px;
        left: 1296px;
        top: 1337px;
    }

    .worm-6{
        width: 232px;
        height: 208px;
        left: 1323px;
        top: 1429px;
    }
</style>
<div class="site-index">
    <div class="label-part">
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
                            <div class="stat-text text-center"> <span class="statistic"> <?= $total_coverage ?> </span> <span>общий  <br> охват людей</span> </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat">
                            <div class="stat-text text-center"> <span class="statistic"> <?= $event_count ?> </span> <span> мероприятий  <br> клуба</span>  </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat">
                            <div class="stat-text text-center"> <span class="statistic"> <?= $member_count ?> </span> <span>участников <br> в клубе</span> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="description">
        <div class="description-body">
            <div class="back">
                <?= Html::img('@web/files/icons/worm-1.svg', ['class' => 'worm worm-1']) ?>
                <?= Html::img('@web/files/icons/worm-2.svg', ['class' => 'worm worm-2']) ?>
                <?= Html::img('@web/files/icons/worm-3.svg', ['class' => 'worm worm-3']) ?>
                <?= Html::img('@web/files/icons/worm-4.svg', ['class' => 'worm worm-4']) ?>
                <?= Html::img('@web/files/icons/worm-5.svg', ['class' => 'worm worm-5']) ?>
                <?= Html::img('@web/files/icons/worm-6.svg', ['class' => 'worm worm-6']) ?>
            </div>

            
        </div>
    </div>    

    <div class="join-us"></div>

    <div class="description">
        <p>Ягодка - компот из самых душевных людей университета ИТМО, который занимается активной деятельностью на базе УСОЦ «Ягодное» :</p>
        <ul class="list3b" style="text-align: left">
            <li>Организация мероприятий </li>
            <li>Реализация и поддержка инициатив студентов </li>
            <li>Развитие инфраструктуры лагеря (навигация, роспись объектов…)</li>
            <li>Развитие информационного пространства </li>
            <li>Развитие и поддержка внутренней культуры, традиций клуба и лагеря</li>
        </ul>
    </div>

    <?php
        if(Yii::$app->user->isGuest) {
            echo "<p class='lead'>Присоединяйся к нам!</p>";
            echo Html::a('Как вступить', ['/site/about'], ['class'=>'btn btn-lg btn-success']);
            echo Html::a('Регистрация', ['/site/register'], ['class'=>'btn btn-lg btn-info']);
        }
    ?>

    
</div>
