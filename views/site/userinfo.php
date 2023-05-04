<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 09/04/2019
 * Time: 14:10
 */

use app\models\User;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $user->berry;
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/user.png']);

//TODO переместить CSS
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
</style>

<div class="row">
    <div class="page-header">
        <h1>
            <?=$user->surname.' '.$user->name.' '.$user->patronymic ?>
            <?php if (!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER):?>
                <a href="<?= Url::to(['site/edit-user', 'uid' => $user->id]) ?>"><sup><i class="glyphicon glyphicon-pencil btn-edit"></i></sup></a>
            <?php endif; ?>
            <small class="header-role"><?= $user->getRoleName() ?></small>
            <small class="header-role"><?= $user->getBirth() ?></small>
        </h1>
    </div>
</div>


<div class="row">

    <!-- Левая колонка -->
    <div class="col-md-3">

        <!-- Блок с аватаркой -->
        <div>
            <?php
            $userAvatar = User::userAvatar($user);
            $img = "<img class='avatar' src='{$userAvatar}'/>";
            if (!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER) {
                echo Html::a($img, ['site/upload-avatar', 'uid' =>$user->id]);
            } else {
                echo $img;
            }
            ?>
        </div>

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <b>
                    Контакты&ensp;
                    <?php if(!Yii::$app->user->isGuest&&$user->id === Yii::$app->user->identity->id):?>
                        <a href="<?= Url::to(['site/contact']) ?>"><small><i class="glyphicon glyphicon-pencil btn-edit"></i></small></a>
                    <?php endif; ?>
                </b>
            </div>

            <!-- Table -->
            <table class="table">
                    <tr>
                        <td><?php echo "<i class=\"fas fa-phone\"></i> :<a href='callto:".$userattributes->phone."'>";?><?= $userattributes->phone ?></td>
                    </tr>
                    <tr>
                        <td><?php echo "<i class=\"fas fa-envelope\"></i> :<a href='mailto:".$userattributes->email."'>";?><?= $userattributes->email ?></td>
                    </tr>
                    <tr>
                        <td><?php echo "<i class=\"fab fa-vk\"></i> :<a href='".$userattributes->vk."'>";?><?= $userattributes->vk ?></td>
                    </tr>
                    <tr>
                        <td><?php echo "<i class=\"far fa-address-card\"></i> :<a href='https://isu.ifmo.ru/pls/apex/f?p=2143:PERSON:102529604385000::NO::PID:".$userattributes->isu."'>";?><?= $userattributes->isu ?></td>
                    </tr>
                    <tr><td><span class="govno">купи говна</span></td></tr>
            </table>
        </div>

    </div>

    <!-- Правая колонка -->
    <div class="col-md-9">

        <!-- Блок с информацией -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Информация:</h3>
            </div>
            <div class="panel-body">
                <?=
                    DetailView::widget([
                        'model' => $user,
                        'attributes' => [
                            [
                                'attribute' => 'berry',
                                'label' => 'Ягодка'
                            ],
                            [
                                'attribute' => 'rating',
                                'label' => 'Рейтинг',
                                'value' => $user->rating()?Html::a($user->rating(), ['site/userrating', 'uid' => $user->id]):0,
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'cash',
                                'label' => 'Ягодки',
                                'value' => $user->cash()?Html::a($user->cash(), ['site/usercash', 'uid' => $user->id]):0,
                                'format' => 'raw'
                            ],
                        ],

                    ])
                ?>

                <div class="events" style="margin-bottom: 20px">
                    <h3>Мероприятия</h3>
                    <?php foreach ($events as $event){
                        if($event->status){
                            echo Html::a($event->name, ['site/event', 'id' => $event->id], ['class' => 'btn btn-warning']).' ';
                        }
                    }?>
                </div>

                <div class="tasks" style="margin-bottom: 20px">
                    <h3>Активные задачи</h3>
                    <?php $count = 0 ;  foreach ($tasks as $task){
                        if($task->status == 0){
                            $count++;
                            echo Html::a($task->name, ['site/tasks', 'id' => $task->id], ['class' => 'btn btn-warning']).' ';
                        }
                    }
                    if ($count == 0) : ?>
                        <p>Ничего не делает</p>
                    <?php endif; ?>

                    <h3>Завершенные задачи</h3>
                    <?php $count = 0 ;  foreach ($tasks as $task){
                        if($task->status == 1){
                            $count++;
                            echo Html::a($task->name, ['site/tasks', 'id' => $task->id], ['class' => 'btn btn-success']).' ';
                        }
                    }
                    if ($count == 0) : ?>
                        <p>Ничего не сделал</p>
                    <?php endif; ?>
                </div>

                <?php if(!Yii::$app->user->isGuest&&((Yii::$app->user->identity->role_id >= User::ROLE_MANAGER))): ?>
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
                    <div>Изменить Рейтинг:</div>
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
                    <div>Изменить количесвто Ягодок:</div>
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

                <?php endif;?>

            </div>
        </div>

<?php 
    $this->registerCssFile('@web/css/userinfo.css')
?>