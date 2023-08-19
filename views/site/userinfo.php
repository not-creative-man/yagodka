<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 09/04/2019
 * Time: 14:10
 */

use app\models\Skill;
use app\models\User;
use app\models\UserAttributes;
use kartik\select2\Select2;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $user->berry;
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/user.png']);

//TODO переместить CSS
?>

<style>
    .fa-custom-top{
        background-image: url(<?='../web/files/icons/starIcon.png'?>);
        width: 35px;
        height: 35px;
    }

    .fa-custom-berry{
        background-image: url(<?='../web/files/icons/berriesIcon.png'?>);
        width: 35px;
        height: 35px;
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

    .fa-custom-firework{
        background-image: url(<?='../web/files/icons/fireworks.png'?>);
        width: 35px;
        height: 35px;
    }
</style>

<div class="panel panel-default panel-main-user-header">
<!-- <div class="row"> Блок с заголовочной частью -->

    <div class="tab-1">
        <h2>
            <?=($user->status == 2)?("Сухофрукт $user->berry"):($user->berry) ?>
            <?php if (!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER):?>
                <a href="<?= Url::to(['site/edit-user', 'uid' => $user->id]) ?>"><sup><i class="glyphicon glyphicon-pencil btn-edit"></i></sup></a>
            <?php endif; ?>
            <small class="header-role"><?= $user->getRoleName() ?></small>
            <!-- <small class="header-role"><?= $user->getBirth() != null ? $user->getBirth() : '' ?></small> -->
        </h2>
    </div>
    
    <div class="tab-2">
    <?php 
        $userAvatar = User::userAvatar($user);
        $img = Html::img($userAvatar, ['class'=>($user->status == 2)?('avatar dryed'):('avatar')]);
        // $img = "<img class='($user->status == 2)?('Сухофрукт $user->berry'):($user->berry)avatar' src='{$userAvatar}'/>";
        if (!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER) {
            echo Html::a($img, ['site/upload-avatar', 'uid' =>$user->id]);
        } else {
            echo $img;
        }
    ?>
    </div>

    <div class="tab-4">
        <div class="tab-4-wrapper-data">
            <div>
                <?php 
                    $attr = UserAttributes::getUserAttributes($user->id);
                    $userData = "<span>"."$user->surname "."$user->name "."$user->patronymic";
                    // echo "$user->surname "."$user->name "."$user->patronymic";
                    if($userattributes->isu != null){
                        $userData = $userData." (<a href='https://isu.ifmo.ru/pls/apex/f?p=2143:PERSON:105073053240714::NO:RP:PID:".$userattributes->isu."'>$userattributes->isu</a>)</span>";
                    } else {
                        foreach ($attr as $attribute){
                            // echo $attribute->attribute_name;
                            switch($attribute->attribute_name){
                                case "isu":
                                    $userData = $userData."(<a href='https://isu.ifmo.ru/pls/apex/f?p=2143:PERSON:105073053240714::NO:RP:PID:".$attribute->isu."'>$attribute->isu</a>)</span>";
                                   break;
                                default:
                                $userData = $userData."</span>";
                            }
                        }
                    }
                    echo $userData;
                ?>
            </div>

            <div>
                <?php
                    echo "<i class=\"fas fa-custom-birth\"></i> <span>".$user->getBirth()."</span>";
                ?>
            </div>

            <div>
                <?php 
                    echo "<i class=\"fas fa-custom-phone\"></i> <a href='callto:".$userattributes->phone."'>".$userattributes->phone."</a>";
                ?>
            </div>

            <div>
                <?php 
                    echo "<i class=\"fab fa-custom-vk\"></i> <a href='".$userattributes->vk."'>".$userattributes->vk."</a>";
                ?>
            </div>

            <div>
                <?php 
                    echo "<i class=\"fab fa-custom-firework\"></i> <span>".date("d.m.Y", strtotime($user->timestamp))."</a>";
                ?>
            </div>
        </div>
        <div class="tab-4-wrapper-stat">
            <div>
                <?php 
                    echo $user->rating()?
                        "<i class=\"fa fa-custom-top\"></i>".Html::a($user->rating(), ['site/userrating', 'uid' => $user->id]):
                        "<i class=\"fa fa-custom-top\"></i>"."<span>0</span>";
                ?>
            </div>
            <div>
                <?php echo $user->cash()?
                    "<i class=\"fa fa-custom-berry\"></i>".Html::a($user->cash(), ['site/usercash', 'uid' => $user->id]):
                    "<i class=\"fa fa-custom-berry\"></i>"."<span>0</span>";
                ?>
            </div>
        </div>
    </div>
</div>

<!-- <div class="panel panel-default panel-user-specials panel-user-skills">
    <div class="skills">
        <h3>Навыки</h3>
        <div>
        <?//php// $count=0; foreach ($skills as $skill){
            //echo "<span class=\"btn btn-skill btn-custom\">$skill->name</span>";
            // echo Html::span($skill->name, ['class' => '']).' ';
            //$count++;
        //}
        //echo "<span class=\"btn btn-skill btn-custom\">+</span>"; // Непонятно, в каком виде должен быть доступно добавление навыка
        //if ($count == 0) : ?>
            <p>Нет навыков</p>
        <?php //endif; ?>
        </div>
    </div>
</div> -->

<div class="panel panel-default panel-user-specials panel-user-events">
    <div class="events">
        <h3>Мероприятия</h3>
        <div>
        <?php foreach ($events as $event){
            if($event->status){
                echo Html::a($event->name, ['site/event', 'id' => $event->id], ['class' => 'btn btn-event btn-custom']).' ';
            }
        }?>
        </div>
    </div>
</div>

<div class="panel panel-default panel-user-specials panel-user-tasks">
    <div class="tasks">
        <h3>Активные задачи</h3>
        <div>
        <?php $count = 0 ;  foreach ($tasks as $task){
            if($task->status == 0){
                $count++;
                echo Html::a($task->name, ['site/tasks', 'id' => $task->id], ['class' => 'btn btn-active btn-custom']).' ';
           }
        }
        if ($count == 0) : ?>
            <p>Ничего не делает</p>
        <?php endif; ?>
        </div>
    </div>
</div>

<div class="panel panel-default panel-user-specials panel-user-done-tasks">
    <div class="tasks">
        <h3>Завершенные задачи</h3>
        <div>
        <?php $count = 0 ;  foreach ($tasks as $task){
            if($task->status == 1){
                $count++;
                echo Html::a($task->name, ['site/tasks', 'id' => $task->id], ['class' => 'btn btn-done btn-custom']).' ';
            }
        }
        if ($count == 0) : ?>
            <p>Ничего не сделал</p>
        <?php endif; ?>
        </div>
    </div>
</div>

<?php if(!Yii::$app->user->isGuest&&((Yii::$app->user->identity->role_id >= User::ROLE_MANAGER))): ?>
    <div class="panel panel-default panel-user-specials panel-user-add">
        <?php $form = ActiveForm::begin([
            'id' => 'rating-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "
                    <div class='row'><div class=\"col-md-12\">{input}</div></div>
                    <div class='row'><div class=\"col-md-12\">{error}</div></div> ",
                'labelOptions' => ['class' => 'col-md-12'],
            ],
        ]); ?>
        <?php
        $button = Html::submitButton('Изменить', ['class' => 'btn btn-success', ]);
        $form = "
        <h3>Изменить Рейтинг</h3>
        <div class='row' style='padding: 15px'>
            <div class='col-md-5'>
                {$form->field($ratingModel, 'count')->textInput(['autofocus' => false, 'placeholder' => 'Количество баллов'])}
            </div>
            <div class='col-md-5'>
                {$form->field($ratingModel, 'comment')->textInput(['autofocus' => false, 'placeholder' => 'Комментарий'])}
            </div>
            <div class='col-md-2'>
                {$button}
            </div>
        </div>"; ?>
        <?= $form ?>
        <?php ActiveForm::end(); ?>

        
        <?php $form = ActiveForm::begin([
            'id' => 'cash-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "
                    <div class='row'><div class=\"col-md-12\">{input}</div></div>
                    <div class='row'><div class=\"col-md-12\">{error}</div></div> ",
                'labelOptions' => ['class' => 'col-md-12'],
            ],
        ]); ?>
        <?php
        $button = Html::submitButton('Изменить', ['class' => 'btn btn-success', ]);
        $form = "
        <h3>Изменить количество Ягодок</h3>
        <div class='row' style='padding: 15px'>
            <div class='col-md-5'>
                {$form->field($cashModel, 'count')->textInput(['autofocus' => false, 'placeholder' => 'Количество ягодок'])}
            </div>
            <div class='col-md-5'>
                {$form->field($cashModel, 'comment')->textInput(['autofocus' => false, 'placeholder' => 'Комментарий'])}
            </div>
            <div class='col-md-2'>
                {$button}
            </div>
        </div>"; ?>
        <?= $form ?>
        <?php ActiveForm::end(); ?>


        
        
    </div>


<?php endif;?>







<?php 
    $this->registerCssFile('@web/css/userinfo.css')
?>