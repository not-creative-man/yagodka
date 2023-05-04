<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 18/06/2019
 * Time: 18:47
 */

namespace app\models;


use yii\db\ActiveRecord;

class TaskToUser extends ActiveRecord
{
    public static function tableName()
    {
        return '{{task_to_user}}';
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

}