<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 26/06/2019
 * Time: 18:18
 */

use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\widgets\Menu;


$this->title = 'Участники клуба';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/members.png']);
?>

<div class="page-header">
    <h1>
        <?= Html::encode('Лидеры клуба') ?>
    </h1>
</div>
<div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-md-8 col-md-push-2 table-body">
                <div class="container-fluid">
                    <!-- <div class="row row-special">
                        <div class="col-12">Toп-5</div>
                    </div> -->
                    <div id="inner-div">
                        <?php $i = 0 ; $count = 0; foreach ($users as $user):?>
                        <!--Если нужная роль то-->
                        <?php if(
                            ($user->role_id  > 2) && ($user->role_id != 4)
                            ) {
                        ?>
                        <div class="row row-odd special">
                            <div CLASS="col-xs-1">
                                <div class="table-text">
                                    <?= $count += 1 ?>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="img-small-borders">
                                    <img src="<?= \app\models\User::userAvatar(\app\models\User::findIdentity($user->id)) ?>" class="img-small">
                                </div>
                            </div>
                            <div class="col-xs-5">
                                <div class="table-text drop-list">
                                    <?= Html::a($user->berry, ['/site/profile', 'uid' => $user->id], ['class' => 'berry-link'] ) ?>
                                </div>
                            </div>
                            <div class="col-xs-3"></div>
                        </div>
                        <?php } ?>
                        <?php $i++ ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Новые заявки от новых людей -->
<div class="page-header">
    <h1>
        <?= Html::encode('Новые заявки'); ?>
    </h1>
</div>

<div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-md-8 col-md-push-2 table-body">
                <div class="container-fluid">
                    <!-- <div class="row row-special">
                        <div class="col-12">Toп-5</div>
                    </div> -->
                    <div id="inner-div">
                        <?php $i = 0 ; $count = 0; foreach ($users as $user):?>
                        <?php if(
                        ($user->role_id  < "2") or ($user->role_id == 4)
                        ) {
                            if($user->status == 0){
                        ?>
                            <div class="row row-odd">
                                <div CLASS="col-xs-1">
                                    <div class="table-text">
                                        <?= $count += 1 ?>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="img-small-borders">
                                        <img src="<?= \app\models\User::userAvatar(\app\models\User::findIdentity($user->id)) ?>" class="img-small">
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="table-text">
                                        <?= Html::a($user->berry, ['/site/profile', 'uid' => $user->id], ['class' => 'berry-link'] ) ?>
                                    </div>
                                </div>
                                <div class="col-xs-1">
                                    <div class="table-text drop-list">
                                        <?php if(
                                            (Yii::$app->user->identity->role_id >= \app\models\User::ROLE_MANAGER) &&
                                            ($user->id != Yii::$app->user->getId()) &&
                                            (Yii::$app->user->identity->role_id > $user->role_id)
                                        ){
                                            echo Nav::widget([
                                                'items' => [[
                                                    'label' => '', 
                                                    'tag' => 'i',
                                                    'class' => '',
                                                    'items' => [
                                                        '<li>'.Html::a('Принять', ['site/confirm', 'uid' => $user->id], ['class' => 'btn btn-success']).'</li>',
                                                        '<li>'.Html::a('Удалить', ['site/delete-user', 'uid' => $user->id], ['class' => 'btn btn-danger']).'</li>',
                                                        // ['label' => 'Home', 'url' => ['site/index']],
                                                        // ['label' => 'Products', 'url' => ['product/index'], 'items' => [
                                                        //     ['label' => 'New Arrivals', 'url' => ['product/index', 'tag' => 'new']],
                                                        //     ['label' => 'Most Popular', 'url' => ['product/index', 'tag' => 'popular']],
                                                        // ]],
                                                    ]],
                                                ],
                                            ]);
                                            // echo Html::a('Принять', ['site/confirm', 'uid' => $user->id], ['class' => 'btn btn-success']);
                                            // echo Html::a('Удалить', ['site/delete-user', 'uid' => $user->id], ['class' => 'btn btn-danger']);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php } ?>
                            <?php $i++ ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Актуальные участники клуба -->

<div class="page-header">
    <h1>
        <?= Html::encode($this->title) ?>
    </h1>
</div>

<div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-md-8 col-md-push-2 table-body">
                <div class="container-fluid">
                    <!-- <div class="row row-special">
                        <div class="col-12">Toп-5</div>
                    </div> -->
                    <div id="inner-div">
                        <?php $i = 0 ; $count = 0; foreach ($users as $user):?>
                        <?php if(
                        ($user->role_id  < "2") or ($user->role_id == 4)
                        ) {
                            if($user->status != 0){
                        ?>
                            <div class="row row-odd <?= ($user->status == 2)?('dryed'):('') ?>">
                                <div CLASS="col-xs-1">
                                    <div class="table-text">
                                        <?= $count += 1 ?>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="img-small-borders">
                                        <img src="<?= \app\models\User::userAvatar(\app\models\User::findIdentity($user->id)) ?>" class="img-small">
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="table-text">
                                        <?= Html::a(($user->status == 2)?("Сухофрукт $user->berry"):("$user->berry"), ['/site/profile', 'uid' => $user->id], ['class' => 'berry-link'] ) ?>
                                    </div>
                                </div>
                                <div class="col-xs-1">
                                    <div class="table-text drop-list">
                                        <?php if(
                                            (Yii::$app->user->identity->role_id >= \app\models\User::ROLE_MANAGER) &&
                                            ($user->id != Yii::$app->user->getId()) &&
                                            (Yii::$app->user->identity->role_id > $user->role_id)
                                        ){
                                            if($user->status == 1){
                                                echo Nav::widget([
                                                    'items' => [[
                                                        'label' => '', 
                                                        'tag' => 'i',
                                                        'class' => '',
                                                        'items' => [
                                                            '<li>'.Html::a('Заблокировать', ['site/confirm', 'uid' => $user->id], ['class' => 'btn btn-danger']).'</li>',
                                                            '<li>'.Html::a('Засушить', ['site/dry-user', 'uid' => $user->id], ['class' => 'btn btn-danger']).'</li>',
                                                            // ['label' => 'Home', 'url' => ['site/index']],
                                                            // ['label' => 'Products', 'url' => ['product/index'], 'items' => [
                                                            //     ['label' => 'New Arrivals', 'url' => ['product/index', 'tag' => 'new']],
                                                            //     ['label' => 'Most Popular', 'url' => ['product/index', 'tag' => 'popular']],
                                                            // ]],
                                                        ]],
                                                    ],
                                                ]);
                                                // echo Html::a('Заблокировать', ['site/confirm', 'uid' => $user->id], ['class' => 'btn btn-danger']);
                                                // echo Html::a('Засушить', ['site/dry-user', 'uid' => $user->id], ['class' => 'btn btn-danger']);
                                            }
                                            else if($user->status == 2){
                                                echo Nav::widget([
                                                    'items' => [[
                                                        'label' => '', 
                                                        'tag' => 'i',
                                                        'class' => '',
                                                        'items' => [
                                                            '<li>'.Html::a('Заблокировать', ['site/confirm', 'uid' => $user->id], ['class' => 'btn btn-danger']).'</li>',
                                                            '<li>'.Html::a('Реабилитировать', ['site/wet-user', 'uid' => $user->id], ['class' => 'btn btn-success']).'</li>',
                                                            // ['label' => 'Home', 'url' => ['site/index']],
                                                            // ['label' => 'Products', 'url' => ['product/index'], 'items' => [
                                                            //     ['label' => 'New Arrivals', 'url' => ['product/index', 'tag' => 'new']],
                                                            //     ['label' => 'Most Popular', 'url' => ['product/index', 'tag' => 'popular']],
                                                            // ]],
                                                        ]],
                                                    ],
                                                ]);
                                                // echo Html::a('Заблокировать', ['site/confirm', 'uid' => $user->id], ['class' => 'btn btn-danger']);
                                                // echo Html::a('Реабилитировать', ['site/wet-user', 'uid' => $user->id], ['class' => 'btn btn-success']);
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php } ?>
                            <?php $i++ ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php 
    $this->registerCssFile('@web/css/rating.css');
?>