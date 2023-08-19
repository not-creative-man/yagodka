<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 01/07/2019
 * Time: 21:21
 */

namespace app\models;


use yii\db\ActiveRecord;
use app\models\User;
use app\models\UserAttributes;
use yii\db\conditions\LikeCondition;

class Rating extends ActiveRecord
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
        return '{{rating}}';
    }

    public static function findByUID($uid) {
        var_dump(UserAttributes::findAll(0));
        return self::find()->where(['user_id' => $uid])->orderBy(['id'=>SORT_DESC])->one();
    }

    public static function findBirthdayPeople($date){
        return User::find()->where(['like','birth', date('m-d')])->all();
        // $query = Course::find()->where(['like', 'name', $q]);
    }
}