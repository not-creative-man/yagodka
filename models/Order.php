<?php


namespace app\models;


use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    const NEED_ATTENDANCE = 1;
    const COMPLETE = 0;

    public static function tableName()
    {
        return '{{order}}';
    }
}