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
<style>
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id >= User::ROLE_MANAGER){ ?>
        @media(max-width: 768px){
            .in > ul{
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 100px;
            }

            .navbar-nav > .dropdown-menu{
                height: 100px;
            }

            .navbar-nav > .dropdown-menu > li{
                height: auto !important;
            }

            .navbar-nav > .dropdown{
                height: 150px !important;
            }

            .open > .dropdown-toggle{
                height: auto !important;
            }
        }
    <?php } else {?>

        @media(max-width: 768px){
            .in > ul{
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 100px;
            }

            .dropdown-menu{
                height: 100px;
            }

            .dropdown-menu > li{
                height: auto !important;
            }

            .dropdown{
                height: 150px !important;
            }

            .open > .dropdown-toggle{
                height: auto !important;
            }
        }
    <?php } ?>
</style>
<body>

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
            
            // '<li>'.'<form>'.'<input class="search-pole" type="text" placeholder="поиск"></input>'.'<i class="fas fa-search"></i>'.'</form>'.'</li>',
            ['label' => 'мероприятия '.$newEvents, 'url' => ['/site/events'], 'options' => ['class' => 'url nav-buttons']],
            ['label' => 'рейтинг', 'url' => ['/site/rating'], 'options' => ['class' => 'url nav-buttons']],
            !Yii::$app->user->isGuest ? (
            [
                'label' => 'заЯбалл',
                'items' => [
                    ['label' => 'заЯбалл', 'url' => ['/shop/shop'], 'options' => ['class' => 'url nav-buttons']],
                    !Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER ?
                        ['label' => 'заказы', 'url' => ['/shop/order-list'], 'options' => ['class' => 'url nav-buttons']]: "",
                    !Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER ?
                        ['label' => 'товары', 'url' => ['/shop/product-list'], 'options' => ['class' => 'url nav-buttons']]: "",
                ],
                'options' => ['class' => 'url nav-buttons']
            ]
            ) : "",
            !Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER ?
                ['label' => "участники". ($newUsers > 0 ?" <sup><span class='new'> {$newUsers} </span></sup>":""), 'url' => ['/site/members'], 'options' => ['class' => 'url nav-buttons']]:"",
            !Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_DEPARTMENT_MANAGER ?
                ['label' => "баллы",
                    'items' => [
                        ['label' => 'выезд', 'url' => ['/site/journey'], 'options' => ['class' => 'url nav-buttons']],
                        ['label' => 'собрание', 'url' => ['/site/meeting'], 'options' => ['class' => 'url nav-buttons']],
                        // ['label' => 'SMM', 'url' => ['/site/smm'], 'options' => ['class' => 'url nav-buttons']],
                ], 'options' => ['class' => 'url nav-buttons']]:"",
            !Yii::$app->user->isGuest ?
                 ['label' => 'задачи '.$newTasks, 'url' => ['/site/tasks'], 'options' => ['class' => 'url nav-buttons']]:"",
        ],
    ]);

    echo Nav::widget(
        [
            'encodeLabels' => false,
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => 
                !Yii::$app->user->isGuest ? (
                    [[
                        'label' => $userinfo,
                        'options' => ['class' => 'active'],
                        'items' => [
                            ['label' => 'профиль', 'url' => ['/site/profile', 'uid' => Yii::$app->user->identity->id], 'options' => ['class' => 'url nav-buttons']],
                            ['label' => 'выход', 'url' => ['/site/logout'], 'options' => ['class' => 'url nav-buttons']]
                        ], 'class' => 'url url-active nav-buttons'
                    ]]
                    ) : (
                        [
                            [
                                'label' => 'вход', 
                                'url' => ['/site/login'], 
                                'class' => 'url url-active', 
                                'options' => ['class' => 'active nav-buttons']
                            ],
                            // [
                            //     'label' => 'обновить мету', 
                            //     'url' => ['/site/updateUserAttr'], 
                            //     'class' => 'url url-active', 
                            //     'options' => ['class' => 'active nav-buttons'],
                            // ]
                            // [
                            //     'label' => 'регистрация', 
                            //     'url' => ['/site/register'], 
                            //     'class' => 'url url-active', 
                            //     'options' => ['class' => 'active nav-buttons'],
                            // ]
                        ]
                    )
                ,
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

    <div class="footer container_site">
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
    $this->registerCssFile('@web/css/main.css');
?>