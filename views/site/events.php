<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 18/06/2019
 * Time: 17:52
 */


use yii\bootstrap\Nav;
use yii\helpers\Html;
use app\models\User;
use app\models\Event;

$this->title = 'Наши мероприятия';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/logo.png']);
?>

<div class='page-header'>
    <h1><?= $this->title ?></h1>
</div>


<?php
if (!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MEMBER): ?>
        <?php if(!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MEMBER): ?>
            <div class="button-wrapper-events">
                <h1><?= Html::a('+ добавить', ['site/newevent'], ['class' => 'btn btn-danger pull-right']) ?></h1>
            </div>
        <?php endif; ?>
        <?php if(count($ucEvents) !== 0) : ?>
            <div class="panel-heading">Неутвержденные мероприятия</div>
            <div class="panel panel-default panel-unconfirmed panel-events">
        <!-- Default panel contents -->
        
        

            <?php foreach ($ucEvents as $record): ?>

                <style>
                <?= '.event-card-'.$record->id?>{
                    <?php if($record->backimage !== null): ?>
                        background: linear-gradient(0deg, rgba(28, 24, 78, 0.6), rgba(28, 24, 78, 0.6)),
                                        url(<?= '../web/files/eventcards/'.$record->backimage ?>) top left/cover;
                    <?php else : ?>
                        background: linear-gradient(0deg, rgba(28, 24, 78, 0.6), rgba(28, 24, 78, 0.6)),
                                        url("../web/files/eventcards/backimage.png") top left/cover;
                    <?php endif; ?>
                }
            </style>
            <?php
                $e2u = \app\models\EventToUser::findOne(['role' => Event::ROLE_MANAGER, 'event_id' => $record->id]);
                $manager_id = $e2u->user_id;
            ?>
            <div class='event-card event-card-<?=$record->id?>'>
                <a href="http://yagodka/web/index.php?r=site%2Fevent&id=<?=$record->id?>" class='back-filter'></a>
                <?php if(Yii::$app->user->identity->role_id >= User::ROLE_MANAGER || Yii::$app->user->identity->id == $manager_id): ?>
                    <?php echo Nav::widget([
                            'items' => [[
                                'label' => '', 
                                'tag' => 'i',
                                'class' => '',
                                'items' => [
                                    '<li>'.Html::a('Утвердить', ['site/confirmevent', 'eid' => $record->id], ['class' => 'btn btn-success']).'</li>',
                                    '<li>'.Html::a('Снять', ['site/confirmevent', 'eid' => $record->id], ['class' => 'btn btn-danger']).'</li>',
                                    '<li>'.Html::a('Удалить', ['site/delete-event', 'eid' => $record->id], ['class' => 'btn btn-danger']).'</li>',
                                ]],
                            ],
                        ]); 
                    ?>
                <?php endif; ?>
                <div class="event-card-wrapper">
                    <span class="event-card-header"><?= $record->name ?></span>
                    <span class="event-card-date"><?= $record->date ?></span>
                </div>
                
            </div>
            <?php endforeach; ?>
        </div>
            <?php endif; ?>
    
<?php endif; ?>

<div class="panel panel-default panel-events">
    <!-- Default panel contents -->
        <?php foreach ($trueEvents as $record): ?>
            <style>
                <?= '.event-card-'.$record->id?>{
                    <?php if($record->backimage !== null): ?>
                        background: linear-gradient(0deg, rgba(28, 24, 78, 0.6), rgba(28, 24, 78, 0.6)),
                                        url(<?= '../web/files/eventcards/'.$record->backimage ?>) top left/cover;
                    <?php else : ?>
                        background: linear-gradient(0deg, rgba(28, 24, 78, 0.6), rgba(28, 24, 78, 0.6)),
                                        url("../web/files/eventcards/backimage.png") top left/cover;                    
                    <?php endif; ?>
                }
            </style>

            <div class='event-card event-card-<?=$record->id?>'>
            <a href="http://yagodka/web/index.php?r=site%2Fevent&id=<?=$record->id?>" class='back-filter'></a>
            <?php if(!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER): ?>
                <style>
                    .event-card-wrapper{
                        margin-top: -24px !important;
                    }
                </style>
            <?php echo Nav::widget([
                    'items' => [[
                        'label' => '', 
                        'tag' => 'i',
                        'class' => '',
                        'items' => [
                            '<li>'.Html::a('Снять', ['site/confirmevent', 'eid' => $record->id], ['class' => 'btn btn-danger dlt-event']).'</li>',
                        ]],
                    ],
                ]); 
            ?><?php endif; ?>
                    <div class="event-card-wrapper">
                        <div class="event-card-wrapper-wrapper">
                            <?php if(!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER): ?>
                                
                            <?php endif; ?>
                        </div>
                        <span class="event-card-header"><?= $record->name ?></span>
                        <span class="event-card-date"><?= $record->date ?></span>
                    </div>
                    
                
            </div>
            
        <?php endforeach; ?>
</div>

<?php 
    $this->registerCssFile('@web/css/rating.css');
    $this->registerCssFile('@web/css/events.css');
?>