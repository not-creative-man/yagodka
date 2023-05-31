<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 18/06/2019
 * Time: 17:52
 */


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
            <div class="col-md-6">
                <h1><?= Html::a('Добавить отчет', ['site/newevent'], ['class' => 'btn btn-success pull-right']) ?></h1>
            </div>
        <?php endif; ?>
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">Неутвержденные мероприятия</div>

            <?php foreach ($ucEvents as $record): ?>

                <style>
                <?= '.event-card-'.$i?>{
                    <?php if($record->backimage !== null): ?>
                        background-image: url(<?= '../web/files/eventcards/'.$record->backimage ?>);
                        background-size: cover;
                    <?php else : ?>
                        background-image: url("../web/files/eventcards/backimage.png");
                    <?php endif; ?>
                }
            </style>

            <div class='event-card event-card-<?=$i?>'>
            <a href="http://yagodka/web/index.php?r=site%2Fevent&id=<?=$i?>" class='back-filter'></a>
                    <div class="event-card-wrapper">
                        <span class="event-card-header"><?= $record->name ?></span>
                        <span class="event-card-date"><?= $record->date ?></span>
                    </div>
                    <?php if(!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER): ?>
                        <?= Html::a('Снять', ['site/confirmevent', 'eid' => $record->id], ['class' => 'btn btn-danger']); ?>
                    <?php endif; ?>
                
            </div>

  
                <tr>
                    <?php
                        $e2u = \app\models\EventToUser::findOne(['role' => Event::ROLE_MANAGER, 'event_id' => $record->id]);
                        $manager_id = $e2u->user_id;
                    ?>
                    <?php if(Yii::$app->user->identity->role_id >= User::ROLE_MANAGER || Yii::$app->user->identity->id == $manager_id): ?>
                        <td style="vertical-align: middle"><?= Html::a($record->name, ['site/editevent', 'eid' => $record->id]) ?></td>
                    <?php else: ?>
                        <td style="vertical-align: middle"><?= $record->name ?></td>
                    <?php endif;?>
                    <td style="vertical-align: middle"><?= $record->date ?></td>
                    <td style="vertical-align: middle"><?= Event::$event_levels[$record->level] ?></td>
                    <?php if(Yii::$app->user->identity->role_id >= User::ROLE_MANAGER): ?>
                        <td style="vertical-align: middle"><?= Html::a('Утвердить', ['site/confirmevent', 'eid' => $record->id], ['class' => 'btn btn-success']); ?>
                            <?= Html::a('Удалить', ['site/delete-event', 'eid' => $record->id], ['class' => 'btn btn-danger']); ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<div class="panel panel-default">
    <!-- Default panel contents -->
        <?php $i = 1; foreach ($trueEvents as $record): ?>
            <style>
                <?= '.event-card-'.$i?>{
                    <?php if($record->backimage !== null): ?>
                        background-image: url(<?= '../web/files/eventcards/'.$record->backimage ?>);
                        background-size: cover;
                    <?php else : ?>
                        background-image: url("../web/files/eventcards/backimage.png");
                    <?php endif; ?>
                }
            </style>

            <div class='event-card event-card-<?=$i?>'>
            <a href="http://yagodka/web/index.php?r=site%2Fevent&id=<?=$i?>" class='back-filter'></a>
                    <div class="event-card-wrapper">
                        <div class="event-card-wrapper-wrapper">
                            <?php if(!Yii::$app->user->isGuest&&Yii::$app->user->identity->role_id >= User::ROLE_MANAGER): ?>
                                <?= Html::a('Снять', ['site/confirmevent', 'eid' => $record->id], ['class' => 'btn btn-danger']); ?>
                            <?php endif; ?>
                        </div>
                        <span class="event-card-header"><?= $record->name ?></span>
                        <span class="event-card-date"><?= $record->date ?></span>
                    </div>
                    
                
            </div>
            
        <?php $i++; endforeach; ?>
</div>

<?php 
    $this->registerCssFile('@web/css/rating.css');
    $this->registerCssFile('@web/css/events.css');
?>