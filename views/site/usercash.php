<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 03/07/2019
 * Time: 15:30
 */

use yii\helpers\Html;

$this->title = 'Изменить ягодки';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => 'files/icons/settings.png']);
?>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Ягодки участника <b><?= Html::a($user->berry, ['site/profile', 'uid' => $user->id]); ?></b></div>

    <!-- Table -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Баллы</th>
            <th>Комментарий</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cash as $record): ?>
            <tr>
                <td><?= $record->count ?></td>
                <td><?= $record->comment ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>