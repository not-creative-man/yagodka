<?php 

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use Codeception\Command\Console;

class IndexForm extends Model
{
    //Регэксп взят из недр yii
    const VALID_EMAIL = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
    public $username;
    public $password;
    public $name;
    public $surname;
    public $patronymic;
    public $role_id;
    public $status;
    public $password_repeat;
    public $berry;
    public $isu;
    public $phone;
    public $vk;
    public $email;
    public $birth;

    public function rules()
    {
        return [
            [['username', 'password', 'name', 'surname', 'berry', 'birth'], 'required', 'message' => "Это поле не может быть пустым"], //, 'vk', 'phone'
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Этот логин уже занят, используйте другой'],
            ['berry', 'unique', 'targetClass' => User::class, 'message' => 'Эта ягода уже занята, используйте другую'],
            //['email','unique','targetClass'=>User::class,'message' => 'Пользователь с таким адресом уже зарегистрирован'],
            ['username', 'string', 'max' => 64],
            ['berry', 'string', 'max' => 64],
            ['password', 'string', 'min' => 6, 'max' => 128],
            [['name', 'surname', 'patronymic'], 'string', 'max' => 32, 'message' => 'Введенные данные должны содержать меньше 32 символов!'],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i', 'message' => 'Имя пользователя не может содержать некоторые символы'],
            //['email', 'match', 'pattern' => self::VALID_EMAIL],
            //['id_itmo', 'integer', 'min' => 100000, 'max' => 9999999],

            // Пока не проверен Админом или менеджером, статус = 0 Непроверенный пользователь
            ['status', 'default', 'value' => User::STATUS_UNAPPROVED],
            ['role_id',  'default', 'value' => User::ROLE_MEMBER],
            [['password', 'password_repeat'], 'required'],
            ['password', 'compare', 'message'=> 'Пароли не совпадают'],
            ['email', 'match', 'pattern' => self::VALID_EMAIL],
            [['birth'], 'date'],
        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // $scenarios['update'] = ['name', 'surname', 'role_id'];
        $scenarios['register'] = ['username', 'password', 'password_repeat', 'name', 'surname', 'berry', 'role_id', 'status', 'patronymic'];
        return $scenarios;
    }


    /* Форма регистрации не работает нормально 
        TODO:Как вариант можно попробовать сделать два окна регистрации подряд, вопрос лишь в том, как работает вызов
    */
    public function register()
    {
        if (!$this->validate())
            return false;

        $user = new User;
        $userAttr = new UserAttributes();
        $userAttrs = [];
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        foreach ($this->attributes as $key => $value) {
            if ($key == 'password_repeat') continue;
            // else if ($key == 'phone' || 
            //          $key == 'isu' ||
            //          $key == 'email' ||
            //          $key == 'vk'){
            //             array_push($userAttrs, [ $key => $value ]);
            //          }
            else $user->$key = $value;
        }
        return $user->save();
        // var_dump($userAttrs);
        // if($user->save() !== false){
        //     file_put_contents('@web/log.txt', $user);
        //     $user = Yii::$app->user->identity;
        //     foreach ($userAttrs as $key => $value) {
        //         $attr = UserAttributes::find()->where(['user_id' => Yii::$app->user->identity->getId(), 'attribute_name' => $key])->one();
        //         $attr = $attr ? $attr : new UserAttributes();
        //         $attr->user_id = $user->id;
        //         switch($key){
        //             case 'phone': $attr->phone = $value; break;
        //             case 'isu' : $attr->isu = $value; break;
        //             case 'email' : $attr->email = $value; break;
        //             case 'vk' : $attr->vk = $value; break;
        //         }
        //         // $attr->save();
        //     }
        // }
        // return false;

    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'password_repeat' => 'Повторите пароль',
            'berry' => 'Ягодка',
            'role_id' => 'Должность',
            'birth' => 'Дата рождения',
        ];
    }

    public function attributeHints()
    {
        return [
            'patronymic' => 'Можно пропустить, если нет',
        ];
    }
}


?>