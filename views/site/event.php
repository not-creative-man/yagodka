<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 18/06/2019
 * Time: 19:11
 */

use yii\helpers\Html;
use app\models\User;
use app\models\EventToUser;
use app\models\Event;

$this->title = $event->name;
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/logo.png']);

$manager_id = EventToUser::find()->where(['event_id' => $event['id'], 'role' => Event::ROLE_MANAGER])->one()->user_id;
$manager = User::findIdentity($manager_id);

$curator_id = EventToUser::find()->where(['event_id' => $event['id'], 'role' => Event::ROLE_CURATOR])->one();
if ($curator_id != NULL) {
    $curator_id = $curator_id->user_id;
    $curator = User::findIdentity($curator_id);
}

$team = $event->users;

?>

<div class="row">
    <div class='page-header clearfix'>
        <h1><?= $event['name'] ?></h1>
    </div>
</div>
<div class="row event-row">
    <div class="col-md-5 tab-1">
        <div class="panel panel-default panel-event-organiser">

            <div class="org main-org">
                <div class="org-wrapper">
                    <div class="tab-1">
                        <?php if(Yii::$app->user->isGuest) :?>
                            <h3>
                                <span><?= $manager['surname'] . ' ' . $manager['name'] . ' ' . $manager['patronymic'] ?></span>
                            </h3>
                        <?php else: ?>
                            <h3>
                                <?= Html::a($manager['surname'] . ' ' . $manager['name'] . ' ' . $manager['patronymic'], ['site/profile', 'uid' => $manager_id]) ?>
                            </h3>
                        <?php endif ?>
                        <small>Главный организатор</small>
                    </div>
                    <div class="tab-2">
                    <div class="img-small-borders">
                            <?= Html::img(User::userAvatar($manager), ['class' => "img-small"]) ?>
                    </div>
                        
                    </div>
                </div>
            </div>



        <?php if ($curator_id != NULL) :?>
            <div class="org">
                <div class="org-wrapper">
                    <div class="tab-1">
                        <?php if(Yii::$app->user->isGuest) :?>
                            <h3>
                                <span><?= $curator->berry ?></span>
                            </h3>
                        <?php else: ?>
                            <h3>
                                <?= Html::a($curator->berry, ['/site/profile', 'uid' => $curator_id], ['class' => 'berry-link']) ?>
                            </h3>
                        <?php endif ?>
                        <small>
                                <?php
                                $e2u = EventToUser::findOne(['user_id' => $curator->id, 'event_id' => $event['id']]);
                                echo \app\models\Rating::$role_names[$e2u->role];
                                ?>
                        </small>
                    </div>
                    <div class="tab-2">
                        <div class="img-small-borders">
                            <img src="<?= \app\models\User::userAvatar(\app\models\User::findIdentity($curator->id)) ?>" class="img-small">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    <?php $i = 0; foreach ($team as $member):?>
        <?php if($member->id != $manager_id && $member->id != $curator_id):?>
            <div class="org">
                <div class="org-wrapper">
                    <div class="tab-1">
                        <?php if(Yii::$app->user->isGuest) :?>
                            <h3>
                                <span><?= $member->berry ?></span>
                            </h3>
                        <?php else: ?>
                            <h3>
                                <?= Html::a($member->berry, ['/site/profile', 'uid' => $member->id], ['class' => 'berry-link']) ?>
                            </h3>
                        <?php endif ?>
                        
                        <small>
                        <?php
                            $e2u = EventToUser::findOne(['user_id' => $member->id, 'event_id' => $event['id']]);
                            echo \app\models\Rating::$role_names[$e2u->role];
                        ?>
                        </small>
                    </div>
                    <div class="tab-2">
                        <div class="img-small-borders">
                            <img src="<?= \app\models\User::userAvatar(\app\models\User::findIdentity($member->id)) ?>" class="img-small">
                        </div>
                    </div>
                </div>
            </div>
            <?php $i++ ?>
        <?php endif; ?>
    <?php endforeach; ?>
        </div>

        
    </div>

    <div class="col-md-5 tab-2" >

        <div class="panel panel-default panel-event-data">
            <div class="about panel-wrapper">
                <h3>О мероприятии</h3>
                <div>
                    <p><b>Дата проведения:</b> <?= $event['date'] ?> </p>
                    <p><b>Уровень мероприятия:</b> <?= Event::$event_levels[$event['level']] ?> </p>
                    <p><b>Место проведения:</b> <?= $event['place'] ?> </p>
                    <p><b>Охват: </b> <?= $event['coverage'] ?> </p>
                </div>
            </div>    
        </div>
            
        <div class="panel panel-default panel-event-data">
            <div class="more panel-wrapper">
                <h3>
                    Описание
                </h3>
                <div>
                    <?= $event['description'] ?>
                </div>
            </div>
        </div>

        <div class="panel panel-default panel-event-data">
            <div class="links panel-wrapper">
                <h3>
                    Ссылки
                </h3>
                <div>
                    <?= $event['links'] ?>
                </div>
            </div>
        </div>

    
        <div class="panel panel-default panel-event-data">
            <div class="plan panel-wrapper">
                <h3>
                    Программа
                </h3>
                <div>
                    <?= $event['program'] ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php 
    $this->registerCssFile('@web/css/event.css');
?>

