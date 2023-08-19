<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 03/07/2019
 * Time: 15:30
 */
use yii\helpers\Html;

?>

<div class='page-header userdata'>
    <h1>Рейтинг участника <?= Html::a("<h1>".$user->berry."</h1>", ['site/profile', 'uid' => $user->id]); ?></h1>
</div>

<div class="panel panel-default panel-userdata">
  <!-- Default panel contents -->

  <div class="panel-wrapper-table">
    <div class="header-line line">
        <div class="tab-1"><span>Баллы      </span></div>
        <div class="tab-2"><span>Комментарий</span></div>
        <div class="tab-3"><span>Автор      </span></div>
    </div>
    <?php foreach ($rating as $record): ?>
            <div class="line">
                <div class="tab-1"><span><?= $record->count ?>  </span></div>
                <div class="tab-2"><span><?= $record->comment ?></span></div>
                <div class="tab-3"><span><?= $record->author ?> </span></div>
            </div>
          <?php endforeach; ?>
  </div>
</div>



<?php 
    $this->registerCssFile('@web/css/userdata.css');
?>