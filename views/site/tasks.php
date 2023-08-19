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

<style>
    .fa-custom-top{
        background-image: url(<?='../web/files/icons/starIcon.png'?>);
        width: 35px;
        height: 35px;
    }

    .fa-custom-berry{
        background: url(../web/files/icons/berriesIcon.png) 10% 10%;
        background-size: 95%;
        width: 25px;
        height: 22px;
    }

    .fa-custom-phone{
        background-image: url(<?='../web/files/icons/phone.png'?>);
        width: 35px;
        height: 35px;
    }

    .fa-custom-vk{
        background-image: url(<?='../web/files/icons/vk-black.png'?>);
        width: 35px;
        height: 35px;
    }

    .fa-custom-birth{
        background-image: url(<?='../web/files/icons/birthIcon.png'?>);
        width: 35px;
        height: 35px;
    }
</style>


<div class="row">
    <div class='page-header'>
        <h1><?= $this->title ?></h1>
    </div>
    
</div>
<div class="panel panel-default panel-tasks">
    <!-- Default panel contents -->
    <div class="panel-heading">
        <span>Активные задачи</span>
        <?php if(!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MEMBER): ?>
            <?= Html::a('Новая задача', ['site/newtask'], ['class' => 'btn btn-danger pull-right']) ?>
        <?php endif; ?>
    </div>
    <!-- Table -->
        <?php foreach ($newTasks as $task): ?>
            <div>
                <div class="task-wrapper">
                    <div class="info-task">
                        <div class="task-inline">
                            <div>
                                <h3 class="task-title">
                                    <?= $task->name ?>
                                    
                                </h3>
                                <?php if(!Yii::$app->user->isGuest && 
                                    Yii::$app->user->identity->role_id >= User::ROLE_MEMBER && 
                                        ($user->id === $task->author && $task->author != null || Yii::$app->user->identity->role_id > User::ROLE_MEMBER)) :
                                            $icon='<sup class="glyphicon glyphicon-pencil btn-edit"></sup>';
                                            echo Html::a($icon, ['site/edit-task', 'tid' => $task->id]); 
                                endif; ?>
                            </div>
                            
                        </div>
                        <div>
                            <p class="restiction">Выполнить до <?= $task->deadline?></p>
                            <p><?= $task->task ?></p>
                            <span><b class="span">Максимум участников:</b> <?= $task->max_user ?><br/></span>
                        </div>
                        
                    </div>

                <!--Если участники на задаче есть, то они выводятся, иначе ничего не происходит-->
                   
                    <div class="task-buttons">
                        <!-- Кнопки учатсников -->
                        <h3><?= $task->cash ?> <i class="fa fa-custom-berry"></i></h3>
                        <?php
                                Modal::begin([
                                'header' => '<h3>' . $task->name . '</h3>',
                                'toggleButton' => [
                                    'label' => 'участники',
                                    'tag' => 'a',
                                    'class' => 'btn btn-users',
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
                                                    <?php if(!Yii::$app->user->isGuest &&
                                                        Yii::$app->user->identity->role_id >= User::ROLE_MEMBER &&
                                                        (Yii::$app->user->identity->id === $task->author && $task->author != null || Yii::$app->user->identity->role_id > User::ROLE_MEMBER)){
                                                            $icon = '<i class="fa fa-times"></i>';
                                                            echo Html::a($icon, ['site/delete-user-task', 'ids' => array('uid' => $user->id, 'tid' => $task->id) ]);
                                                        } ?>                                                      
                                                </div>
                                            </div>
                                        </div>
                                            <?php $i++ ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php Modal::end(); ?>
                                    <!-- если  -->
                                <?php if(!in_array(Yii::$app->user->identity, $users[$task->id])&&(count($users[$task->id]) < $task->max_user) ): ?>
                                    <?= Html::a('Взять задачу', ['site/confirm-task-to-user', 'tid' => $task->id], ['class' => 'btn btn-success']); ?>
                                        <!-- <a href="#" class="btn btn-primary" style="background-color: #904879; border-color: #904879"><?= $task->cash ?><span class="glyphicon glyphicon-apple"></span></a> -->
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
                    <!-- <div class="member-task">
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
                                
                            </div>
                        </div>
                    </div> -->

                </div>
            </div>
        <?php endforeach; ?>
    </div>
    



<div class="panel panel-default panel-tasks panel-completed-tasks">
<!-- Default panel contents -->
    <div class="panel-heading">
        <span>Завершенные задачи</span>
    </div>
    <!-- Table -->
    <?php foreach ($didTasks as $task): ?>
            <div>
                <div class="task-wrapper">
                    <div class="info-task">
                        <div class="task-inline">
                            <div>
                                <h3 class="task-title">
                                    <?= $task->name ?> 
                                </h3>
                            </div>
                        </div>
                        <div>
                            <p><?= $task->task ?></p>
                        </div>
                        
                    </div>

                <!--Если участники на задаче есть, то они выводятся, иначе ничего не происходит-->
                   
                    <div class="task-buttons">
                        <!-- Кнопки учатсников -->
                        <?php
                            Modal::begin([
                                'header' => '<h3>' . $task->name . '</h3>',
                                'toggleButton' => [
                                    'label' => 'участники',
                                    'tag' => 'a',
                                    'class' => 'btn btn-users',
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
                                                <?php if(!Yii::$app->user->isGuest &&
                                                    Yii::$app->user->identity->role_id >= User::ROLE_MEMBER &&
                                                    ($user->id === $task->author && $task->author != null || Yii::$app->user->identity->role_id > User::ROLE_MEMBER)) :
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

                        <?php if((Yii::$app->user->identity->role_id >= \app\models\User::ROLE_MANAGER)){
                                    echo Html::a('Задача не выполнена', ['site/rebut-task', 'tid' => $task->id], ['class' => 'btn btn-danger']);
                                }
                        ?>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
</div>

<?php 
    $this->registerCssFile('@web/css/tasks.css');
?>


 <?php $size=count($users[$task->id]); if($size > 0): ?>
                        <?php endif; ?>