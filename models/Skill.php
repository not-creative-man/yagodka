<?php

namespace app\models;


use yii\db\ActiveRecord;

class Skill extends ActiveRecord
{
    const ROLE_MANAGER = 1;
    const ROLE_ORGANIZER = 2;
    const ROLE_WORKER = 3;
    const ROLE_VOLUNTEER = 4;
    const ROLE_CURATOR = 5;

    public static function tableName()
    {
        return '{{skills}}';
    }

    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]);
    }

    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable(SkillToUser::tableName(), ['skill_id' => 'id']);
    }
}