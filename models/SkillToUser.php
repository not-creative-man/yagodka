<?php

namespace app\models;


use yii\db\ActiveRecord;

class SkillToUser extends ActiveRecord
{
    public static function tableName()
    {
        return '{{skill_to_user}}';
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getSkill()
    {
        return $this->hasOne(Skill::class, ['id' => 'skill_id']);
    }

}