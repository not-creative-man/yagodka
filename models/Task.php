<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 18/06/2019
 * Time: 17:53
 */

namespace app\models;


use yii\db\ActiveRecord;

class Task extends ActiveRecord
{
    const ROLE_MANAGER = 1;
    const ROLE_ORGANIZER = 2;
    const ROLE_WORKER = 3;
    const ROLE_VOLUNTEER = 4;
    const ROLE_CURATOR = 5;

    public static function tableName()
    {
        return '{{task}}';
    }

    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]);
    }

    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable(TaskToUser::tableName(), ['task_id' => 'id']);
    }

    public function getAuthor(){
        return $this->author;
    }
}