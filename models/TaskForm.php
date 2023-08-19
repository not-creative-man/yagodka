<?php
/**
 * Created by PhpStorm.
 * User: kuratovevgenij
 * Date: 03/07/2019
 * Time: 21:14
 */

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\helpers\Html;

class TaskForm extends Model
{
    public $name;
    public $task;
    public $cash;
    public $deadline;
    public $max_user;

    public function rules()
    {
        return [
            [['name', 'task', 'cash', 'deadline', 'max_user'], 'required', 'message' => "Это поле не может быть пустым"],
            [['cash', 'max_user'], 'integer'],
        ];
    }

    public function register($uid)
    {
        if (!$this->validate())
            return false;

        $task = new Task();
        $dep = new TaskToUser();
        foreach ($this->attributes as $key => $value) {
            $task->$key = $value;
        }
        $task->status = 0;
        $task->author = $uid;
        $task->save();

        return true;
    }
    public function change($tid) {
        $task = Task::findIdentity($tid);
        foreach ($this->attributes as $key => $value) {
            $task->$key = $value;
        }
        $task->save();

        return true;
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Задание',
            'task' => 'Суть задания',
            'cash' => 'Количество ягодок за задание',
            'deadline' => 'До какого числа задание',
            'max_user' => 'Максимальное количество выполняющих',
        ];
    }

}