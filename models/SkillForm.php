<?php

namespace app\models;


use yii\base\Model;
use app\models\User;

class SkillForm extends Model
{

    public $skill;

    public function rules()
    {
        return [
            // ['count', 'required', 'message' => 'Это поле не может быть пустым'],
            // ['count', 'integer', 'message' => 'Неверный формат числа'],
            // ['skill_name', 'required', 'message' => 'Введите комментарий'],
            // ['ski', 'string', 'message' => 'Неверный формат комментария'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'skillName' => 'Добавить навык',
        ];
    }

    public function change($uid) {
        if ($this->validate()){
            $record = new SkillToUser();
            foreach ($this->attributes as $key => $value) {
                $record->$key = $value;
            }
            $record->user_id = $uid;
            $user = User::findIdentity($uid);
            $user->cash += $this->count;
            return $record->save() && $user->save();
        }
    }
}