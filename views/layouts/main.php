<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use app\models\Event;
use app\models\Task;
use app\models\Order;

AppAsset::register($this);

use app\models\User;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link type='image/png' href=""
    <?php $this->head() ?>
    <!-- <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> -->
    <!-- Шрифт -->
<!--    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">-->
<!--    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">-->

</head>
<body>
    <style>
        .logo-img{
            height: var(--logo-size);
            width: var(--logo-size);
        }

        .navbar-brand{
            padding: 0;
            height: 100px;
            width: 100px;
        }

        .navbar-inverse{
            height: 100px;
            background-color: var(--header-footer-violet-clr);
        }

        .wrap > .container {
    padding: 100px 0 20px;
}
        
        .navbar >.container, .nav{
            height: 100px;
        }

        h1, .h1{
            /* font-family: "Montserrat" !important; */
            font-size: 96px;
        }

        .active > a,
        .url-active,
        .navbar-right > li > a{
            color: var(--main-red-clr) !important;
            background-color: var(--header-footer-violet-clr) !important;
        }

        .navbar-inverse .navbar-nav > .open > a{
            color: var(--main-yellow-clr) !important;
            background-color: var(--header-footer-violet-clr) !important;
        }

        .search-template{
            height: 40px;
            width: 250px;
            background-color: aliceblue;
            border: 1px solid var(--header-footer-violet-clr);
        }

        .navbar-nav > li > .dropdown-menu{
            width: 92px !important;
        }

        .navbar-inverse .navbar-nav > li > a, 
        .navbar-inverse .navbar-nav > li > form,
        .navbar-inverse .navbar-nav > .open > a,
        .dropdown-menu > li > a,
        .dropdown-menu > li > a:hover,
        .footer{
            /* padding: calc((var(--logo-size) - var(--default-text-line-size)) / 2) 15px;  */
            color: var(--main-white-color);
            font-family: var(--main-font);
            font-weight: 700;
        }

        .navbar-inverse .navbar-nav > li > form{
            color: var(--header-footer-violet-clr);
            padding: calc((var(--logo-size) - var(--default-input-height)) / 2) 15px;
        }

        .navbar-inverse .navbar-nav > li > form > input{
            height: var(--default-input-height);
            width: var(--default-input-width);
            border-radius: var(--default-input-border-radius);
        }

        .dropdown-menu,
        .dropdown-menu > li > a:hover,
        .footer{
            background-color: var(--header-footer-violet-clr) !important;
            min-width: 90px;
        }

        .dropdown-menu > li > a,
        .dropdown-menu > li > a:hover{
            line-height: var(--dropdown-menu-a-line-height);
            text-align: center;
            padding: 5px 12px; 
        }

        .footer{
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .wrapper{
            display: flex;
        }

        .contacts{
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: auto 75px;
        }

        .footer-label{
            margin-bottom: 10px
        }

        .contacts-icons > a{
            margin: auto 10px;
        }

        .navbar-toggle{
            /* display: flex;
            margin:auto 15px auto 0; */
        }
        
    </style>

<?php
    $userinfo = !Yii::$app->user->isGuest ?''. 
        // <img class="very-small-avatar" src="' .
        // User::userAvatar(Yii::$app->user->identity) .
        // '">'.
        Yii::$app->user->identity->berry: "";

    $newUsers = User::find()->where(['status' => 0])->count();
    $newEvents = Event::find()->where(['status' => 0])->count();
    $newEvents = !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id >= User::ROLE_MANAGER && $newEvents != 0 ? "<sup><span class='new'> {$newEvents} </span></sup>" : '';

    $newTasks = Task::find()->where(['status' => 0])->count();
    $newTasks = !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id >= User::ROLE_MANAGER && $newTasks != 0 ? "<sup><span class='new'> {$newTasks} </span></sup>" : '';
?>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/files/icons/logotype.png', ['alt' => Yii::$app->name, 'class' => 'logo-img']),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget(
        [
        'encodeLabels' => false,
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            '<li>'.'<form>'.'<input type="text" placeholder="поиск"></input>'.'</form>'.'</li>',
            ['label' => 'мероприятия '.$newEvents, 'url' => ['/site/events'], 'class' => 'url'],
            ['label' => 'рейтинг', 'url' => ['/site/rating'], 'class' => 'url'],
            !Yii::$app->user->isGuest ? (
            [
                'label' => 'заЯБалл',
                'items' => [
                    ['label' => 'магазин', 'url' => ['/shop/shop']],
                    ['label' => 'заказы', 'url' => ['/shop/order-list']],
                    !Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER ?
                        ['label' => 'товары', 'url' => ['/shop/product-list']]: "",
                ],
                'class' => 'url'
            ]
            ) : "",
            !Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER ?
                ['label' => "участники". ($newUsers > 0 ?" <sup><span class='new'> {$newUsers} </span></sup>":""), 'url' => ['/site/members'], 'class' => 'url']:"",
            !Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER ?
                ['label' => "баллы",
                    'items' => [
                        ['label' => 'выезд', 'url' => ['/site/journey']],
                        ['label' => 'собрание', 'url' => ['/site/profile', 'uid' => Yii::$app->user->identity->id]],
                        ['label' => 'SMM', 'url' => ['/site/smm']],
                ], 'class' => 'url']:"",
            !Yii::$app->user->isGuest ?
                 ['label' => 'задачи '.$newTasks, 'url' => ['/site/tasks'], 'class' => 'url']:"",
        ],
    ]);

    echo Nav::widget(
        [
            'encodeLabels' => false,
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                !Yii::$app->user->isGuest ? (
                    [
                        'label' => $userinfo,
                        'items' => [
                            ['label' => 'профиль', 'url' => ['/site/profile', 'uid' => Yii::$app->user->identity->id]],
                            '<li>' . Html::a('выход', ['/site/logout'], ['data' => ['method' => 'post']]) . '</li>',
                        ], 'class' => 'url url-active'
                    ]
                    ) : (
                        ['label' => 'вход', 'url' => ['/site/login'], 'class' => 'url url-active']
                    ),
                ],
    ]);
    NavBar::end();
    ?>

    <div class="container container_site">
        
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

    <div class="footer container-site">
        <div class="wrapper">
            <div class="contacts">
                <div class="footer-label">
                    <span>Ягодное</span>
                </div>
                <div class="contacts-icons">
                    <?= Html::tag('a', Html::img('@web/files/icons/vk-new.png'), ['href' => 'https://vk.com/yagodnoeitmo']) ?>
                    <?= Html::tag('a', Html::img('@web/files/icons/tg.png'), ['href' => 'https://t.me/yagodnoeitmo']) ?>
                    <!-- Переделать ссылку на инст -->
                    <?= Html::tag('a', Html::img('@web/files/icons/inst.png'), ['href' => 'https://www.instagram.com/yagodnoe_itmo/']) ?>
                    <?= Html::tag('a', Html::img('@web/files/icons/www.png'), ['href' => 'https://yagodnoe.itmo.ru/']) ?>

                </div>
            </div>
            <div class="contacts">
                <div class="footer-label">
                    <span>Ягодка</span>
                </div>
                <div class="contacts-icons">
                    <?= Html::tag('a', Html::img('@web/files/icons/vk-new.png'), ['href' => 'https://vk.com/yagodka_club']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<?php 
    $this->registerCssFile('@web/css/header.css')
?>
<?php 
    $this->registerCssFile('@web/css/footer.css')
?>