<?php


namespace app\models;


use yii\base\Model;

class ProductForm extends Model
{
    public $name;
    public $cost;
    public $size = "";
    public $color = "";
    public $image;
    public $active;

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Это поле не может быть пустым'],
            ['cost', 'required', 'message' => 'Это поле не может быть пустым'],
            ['cost', 'integer', 'message' => 'Неверный формат числа'],
            ['size', 'string', 'message' => 'Это поле должно быть строкой'],
            ['color', 'string', 'message' => 'Это поле должно быть строкой'],
            ['active', 'integer', 'message' => 'Это поле должно быть строкой'],
            [['image'], 'file', 'extensions' => 'png, jpg'],
            [['image'], 'file', 'maxSize' => 20000000]
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название товара',
            'cost' => 'Стоимость',
            'size' => 'Размеры',
            'color' => 'Цвета',
            'image' => 'Изображение',
            'active' => 'Доступен после создания'
        ];
    }

    public function update($product_id) {
        if (!$this->validate())
            return false;

        $product = Product::findOne(["id" => $product_id]);
        foreach ($this->attributes as $key => $value) {
            if ($key == 'image') continue;
            $product->$key = $value;
        }

        if ($this->image) {
            $filename = $this->formFileName();
            $this->image->saveAs("files/products/" . $filename);
            if ($product->image && file_exists("files/products/" . $product->image)) unlink("files/products/" . $product->image);
            $product->image = $filename;
        }

        return $product->save();
    }

    public function create() {
        if (!$this->validate())
            return false;

        $product = new Product();
        foreach ($this->attributes as $key => $value) {
            if ($key == 'image') continue;
            $product->$key = $value;
        }

        if ($this->image) {
            $filename = $this->formFileName();
            $this->image->saveAs("files/products/" . $filename);
            $product->image = $filename;
        }

        return $product->save();
    }

    private function formFileName()
    {
        $timestamp = new \DateTime();
        $timestamp = $timestamp->getTimestamp();
        $filename =  $timestamp . '.' . $this->image->extension;
        return $filename;
    }
}