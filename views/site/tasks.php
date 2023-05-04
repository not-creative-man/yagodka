<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 18/06/2019
 * Time: 17:52
 */

use yii\bootstrap\Modal;
use yii\helpers\Html;
use app\models\User;
use app\models\Task;

$this->title = 'Задачи';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/logo.png']);
?>
<style xmlns="http://www.w3.org/1999/html">
    .test-panel {
        margin:  10px;
    }

    .glyphicon {
        font-size: 30px;
    }

    .glyphicon-ok-circle {
        color: lawngreen;
    }

    .glyphicon-remove-circle {
        color: red;
    }

    .glyphicon-ban-circle {
        color: orange;
    }

    .header-role{
        text-transform: uppercase;
    }

    .avatar{
        width: 100%;
        padding-bottom: 15px;
    }

    .null-panel{
        padding: 0;
    }

    .small-avatar{
        width: 48px;
        height: 48px;
        border-radius: 50%;
    }

    .groupmate-well{
        margin: 5px;
    }

    .helper{
        color: #777;
    }

    .btn-edit{
        font-size: small;
        color: #777777;
    }

    #col {
        vertical-align: middle;
        width: 30%;
    }
    .member-task {
        height: content-box;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        max-width: 400px;
        margin: 0;
        flex-shrink: 0;
    }
    @media (max-width: 990px)  {
        .member-task {
            max-width: 300px;
            flex-shrink: 0;
        }
    }
    @media (max-width: 700px)  {
        .member-task {
            max-width: 200px;
            flex-shrink: 0;
        }
    }
    .member-task h3 {
        margin-top: 0;
        align-self: flex-start;!important;
    }
    .member-img {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;

    }
    .info-task {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    tr {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border: 1px solid #ddd;
    }
    .table > tbody > tr > td:last-child {
        align-self: center;
    }
    .table > tbody > tr > td {
        border: none;!important;
    }
    .br-50 {
        border-radius: 50%;
        outline: none;
    }
    .more {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-size: 30px;
        font-weight: bold;
        border-radius: 50%;
        color: #9c5685;
    }
    .task-buttons {
        display: flex;
        flex-direction: row;
    }
    .task-buttons .btn:first-child {
        background-color: #9c5685;
        border-color: #9c5685;
        margin-left: 0;
    }
    .task-buttons .btn-success:nth-child(2) {
        background-color: #33a64b;
        border: #33a64b;
        margin:0 10px 0 20px;
    }
    .task-buttons .btn:last-child {
        background-color: #d82a43;
        border: #d82a43;
        margin-right: 0;
    }
    .task-title {
        vertical-align: middle;
        margin-top: 5px;
        margin-bottom: 2px;
        font-weight: bold;
    }
    .task-title + p {
        font-weight: bold;
        color: grey;
    }
    .task-inline {
        display: flex;
        flex-direction: row;
    }
    .btn-group {
        font-size: 14px;
    }
    .btn-group a {
        font-size: 14px;
        height: 100%;
    }
    .glyphicon {
        font-size: 14px;
    }
</style>
<div class="row">
    <div class='page-header clearfix' style="margin-top: 0;">
        <div class="col-md-6">
            <h1><?= $this->title ?></h1>
        </div>
        <?php if(!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MEMBER): ?>
            <div class="col-md-6">
                <h1><?= Html::a('Новая задача', ['site/newtask'], ['class' => 'btn btn-success pull-right']) ?></h1>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Активные задачи</div>
    <!-- Table -->
    <table class="table">
        <tbody>
        <?php foreach ($newTasks as $task): ?>
            <tr>
                <td>
                    <div class="info-task">
                        <div class="task-inline">
                            <div>
                                <h3 class="task-title"><?= $task->name ?>.</h3>
                                <p>Выполнить до <?= $task->deadline?></p>
                            </div>
                            <?php if(!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MEMBER) :
                                $icon='<sup class="fa fa-pencil"></sup>';
                                echo Html::a($icon, ['site/edit-task', 'tid' => $task->id]); endif; ?>
                        </div>
                        <div>
                            <p style="vertical-align: middle; margin-bottom: 20px;"><?= $task->task ?><br><b class="span">Максимум участников:</b> <?= $task->max_user ?></p>
                        </div>
                        <div class="task-buttons">
                            <?php if(!in_array(Yii::$app->user->identity, $users[$task->id])&&(count($users[$task->id]) < $task->max_user) ): ?>
                                <div class="btn-group">
                                    <?= Html::a('Взять задачу', ['site/confirm-task-to-user', 'tid' => $task->id], ['class' => 'btn btn-success']); ?>
                                    <a href="#" class="btn btn-primary" style="background-color: #904879; border-color: #904879"><?= $task->cash ?><span class="glyphicon glyphicon-apple"></span></a>
                                </div>
                            <?php else: if ((in_array(Yii::$app->user->identity, $users[$task->id]))):?>
                                <?= Html::a('Отказаться', ['site/disprove-task-to-user', 'tid' => $task->id], ['class' => 'btn btn-danger']); ?>
                                <?php else: ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if(Yii::$app->user->identity->role_id >= User::ROLE_MANAGER){
                                echo Html::a('Задача выполнена', ['site/confirm-task', 'tid' => $task->id], ['class' => 'btn btn-success']);
                                echo Html::a('Удалить', ['site/delete-task', 'tid' => $task->id], ['class' => 'btn btn-danger']);
                            }
                            ?>
                        </div>
                    </div>
                </td>
                <!--Если участники на задаче есть, то они выводятся, иначе ничего не происходит-->
                <?php $size=count($users[$task->id]); if($size > 0): ?>
                    <td class="member-task">
                        <div class="member-img" style="display: flex;">
                            <?php foreach ($users[$task->id] as $user): ?>
                                <div class="img-small-borders">
                                    <img src="<?= \app\models\User::userAvatar($user) ?>" class="img-small br-50">
                                </div>
                                <?php if($size > 3): ?>
                                    <?php if ($users[$task->id][2] == $user) { break;}?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <div class="img-small-borders">
                                <?php
                                Modal::begin([
                                    'header' => '<h3>' . $task->name . '</h3>',
                                    'toggleButton' => [
                                        'label' => '&#8226;     &#8226;     &#8226;',
                                        'tag' => 'i',
                                        'class' => 'more',
                                    ]
                                ]);
                                ?>
                                <div class="row">
                                    <div class="panel-body" style="padding: 0 15px 0 15px">
                                        <h3>Все участники</h3>
                                        <?php $i = 0 ; $count = 0; foreach ($users[$task->id] as $user):?>
                                            <div class="row row-<?= ((($i % 2) == 1)?('even'):('odd'))?>">
                                                <div CLASS="col-xs-1">
                                                    <div class="table-text">
                                                        <?= $count += 1 ?>
                                                    </div>
                                                </div>
                                                <div class="col-xs-3">
                                                    <div class="img-small-borders">
                                                        <img src="<?= \app\models\User::userAvatar($user) ?>" class="img-small">
                                                    </div>
                                                </div>
                                                <div class="col-xs-5">
                                                    <div class="table-text">
                                                        <?= Html::a($user->berry, ['/site/profile', 'uid' => $user->id], ['class' => 'berry-link'] ) ?>
                                                    </div>
                                                </div>
                                                <div class="col-xs-1"></div>
                                                <div class="col-xs-1">
                                                    <div class="table-text">
                                                        <?php if(!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MEMBER) :
                                                            $icon = '<i class="fa fa-times"></i>';
                                                            echo Html::a($icon, ['site/delete-user-task', 'ids' => array('uid' => $user->id, 'tid' => $task->id) ]); endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++ ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php Modal::end(); ?>
                            </div>
                        </div>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Завершенные задачи</div>

    <!-- Table -->
    <table class="table">
        <tbody>
        <?php foreach ($didTasks as $task): ?>
            <tr>
                <td>
                    <div class="info-task">
                        <h3 class="task-title"><?= $task->name ?>.</h3>
                        <div>
                            <p style="vertical-align: middle"><?= $task->task ?></p>
                        </div>
                        <div class="d-flex">
                            <?php if((Yii::$app->user->identity->role_id >= \app\models\User::ROLE_MANAGER)){
                                echo Html::a('Задача не выполнена', ['site/rebut-task', 'tid' => $task->id], ['class' => 'btn btn-danger']);
                            }
                            ?>
                        </div>
                    </div>

                </td>
                <!--Если участники на задаче есть, то они выводятся, иначе ничего не происходит-->
                <?php $size=count($users[$task->id]); if($size > 0): ?>
                    <td class="member-task">
                        <div class="member-img" style="display: flex;">
                            <!--Вывод участников <=3 -->
                            <?php foreach ($users[$task->id] as $user): ?>
                                <div class="img-small-borders">
                                    <img src="<?= \app\models\User::userAvatar($user) ?>" class="img-small br-50">
                                </div>
                                <?php if($size > 3): ?>
                                    <!--Прерывание на 3 проходе -->
                                    <?php if ($users[$task->id][2] == $user) { break;}?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <!--pupup -->
                            <div class="img-small-borders">
                                <?php
                                Modal::begin([
                                    'header' => '<h3>' . $task->name . '</h3>',
                                    'toggleButton' => [
                                        'label' => '&#8226;     &#8226;     &#8226;',
                                        'tag' => 'i',
                                        'class' => 'more',
                                    ]
                                ]);
                                ?>
                                <div class="row">
                                    <div class="panel-body" style="padding: 0 15px 0 15px">
                                        <h3>Все участники</h3>
                                        <?php $i = 0 ; $count = 0; foreach ($users[$task->id] as $user):?>
                                            <div class="row row-<?= ((($i % 2) == 1)?('even'):('odd'))?>">
                                                <div CLASS="col-xs-1">
                                                    <div class="table-text">
                                                        <?= $count += 1 ?>
                                                    </div>
                                                </div>
                                                <div class="col-xs-3">
                                                    <div class="img-small-borders">
                                                        <img src="<?= \app\models\User::userAvatar($user) ?>" class="img-small">
                                                    </div>
                                                </div>
                                                <div class="col-xs-5">
                                                    <div class="table-text">
                                                        <?= Html::a($user->berry, ['/site/profile', 'uid' => $user->id], ['class' => 'berry-link'] ) ?>
                                                    </div>
                                                </div>
                                                <div class="col-xs-1"></div>
                                                <div class="col-xs-1"></div>
                                            </div>
                                            <?php $i++ ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php Modal::end(); ?>
                            </div>
                        </div>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
