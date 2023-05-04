<?php


namespace app\models;


use Yii;
use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    public static function tableName()
    {
        return '{{product}}';
    }

    public static function productAvatar($product){
        if (!is_null($product->image)){
            return Yii::getAlias('@web').'/files/products/'.$product->image;
        } else {
            return Yii::getAlias('@web').'/files/products/placeholder.png';
        }

    }
}