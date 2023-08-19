<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 09/09/2019
 * Time: 21:22
 */

namespace app\models;


use yii\base\Model;

class MeetingForm extends Model
{
    const JOURNEY_COST = 2;
    public $members;
    public $name;

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Введите название собрания'],
            ['members', 'required', 'message' => 'Выберите хотя бы одного участника собрания']
        ];
    }

    public function add() {
        if (!$this->validate())
            return false;

        foreach ($this->members as $member){
            $rating = new Rating();
            $rating->user_id = $member;
            $rating->count = JourneyForm::JOURNEY_COST;
            $rating->comment = "Собрание: \"{$this->name}\"";
            $rating->service = 0;
            $rating->save();

            $cash = new Cash();
            $cash->user_id = $member;
            $cash->count = JourneyForm::JOURNEY_COST;
            $cash->comment = "Собрание: \"{$this->name}\"";
            $cash->service = 0;
            $cash->save();

            $user = User::findIdentity($member);
            $user->cash += JourneyForm::JOURNEY_COST;
            $user->save();
        }

        return true;
    }

    public function attributeLabels()
    {
        return [
          'name' => 'Название собрания',
          'members' => 'Участники собрания'
        ];
    }
}