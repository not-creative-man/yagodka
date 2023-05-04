<?php


namespace app\models;


use yii\db\ActiveRecord;

class Cash extends ActiveRecord
{
    public static $role_rating = [
        1 => 25,
        2 => 20,
        3 => 15,
        4 => 10,
        5 => 0,
    ];

    public static $role_names = [
        1 => 'Главный организатор',
        2 => 'Организатор',
        3 => 'Ответственный исполнитель',
        4 => 'Волонтер',
        5 => 'Куратор'
    ];

    public static function tableName()
    {
        return '{{cash}}';
    }

    public static function findByUID($uid) {
        return self::findOne(['user_id' => $uid]);
    }
}