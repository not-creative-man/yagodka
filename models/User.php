<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 29.05.2018
 * Time: 20:15
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Класс пользователя
 * @package app\models\dbs
 * @property int $id [int(10) unsigned]
 * @property string $create_stamp [datetime]
 * @property string $update_stamp [datetime]
 * @property string $username [varchar(64)]
 * @property string $password [varchar(128)]
 * @property string $name [varchar(32)]
 * @property string $surname [varchar(32)]
 * @property string $patronymic [varchar(32)]
 * @property bool $status [tinyint(1)]
 * @property int $role [int(1) unsigned]
 * @property string $department [varchar(64)]
 * @property string $access_token [varchar(128)]
 * @property string $email [varchar(64)]
 * @property string $avatar
 * Если что это пиздеш
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_UNAPPROVED = 0;
    const STATUS_APPROVED = 1;
    const STATUS_DELETED = 2;

    const ROLE_MEMBER = 1;
    const ROLE_MANAGER = 3;
    const ROLE_ADMIN = 4;
    const ROLE_SECRETORY = 2;
    const ROLE_MENTOR = 5;

    public static function tableName()
    {
        return '{{user}}';
    }

    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username){
        return self::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return hash('sha512', $this->password);
    }

    public function validateAuthKey($authKey)
    {
        return hash('sha512', $this->password) === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function validateUsername($username)
    {
        return $username === $this->username;
    }

    public function validateStatus(): bool
    {
        return $this->status === 1;
    }

    public function getUserAttributes()
    {
        return $this->hasOne(UserAttributes::class, ['user_id' => 'id']);
    }

    public function getEvents()
    {
        return $this->hasMany(Event::class, ['id' => 'event_id'])
            ->viaTable(EventToUser::tableName(), ['user_id' => 'id']);
    }
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['id' => 'task_id'])
            ->viaTable(TaskToUser::tableName(), ['user_id' => 'id']);
    }

    public function userInitials(){
        return $this->surname . ' ' .
            mb_substr($this->name, 0, 1) . '. ' .
            (!empty($this->patronymic)?(mb_substr(($this->patronymic), 0, 1) . '.') : '');
    }

    public function setToken()
    {
        $token = Yii::$app->getSecurity()->generatePasswordHash($this->create_stamp.$this->update_stamp);
        $this->access_token = $token;
    }

    /**
     * @param $user
     * @return string
     */
    public static function userAvatar($user){
        if (!is_null($user->img_url) && file_exists("files/avatars/".$user->img_url)){
            return Yii::getAlias('@web').'/files/avatars/'.$user->img_url;
        } else {
            return Yii::getAlias('@web').'/files/avatars/noavatar.png';
        }

    }

    public function getRoleName(){
        switch ($this->role_id) {
            case User::ROLE_ADMIN :
                return 'admin';
            case User::ROLE_SECRETORY :
                return 'Секретарь';
            case User::ROLE_MANAGER:
                return 'Менеджер клуба';
            case User::ROLE_MENTOR:
                return 'Ментор клуба';
            default :
                return 'Член клуба';
        }
    }

    public function getBirth(){
        return Yii::$app->formatter->format($this->birth, 'date');
    }

    public function rating() {
        $count = Rating::find()->where(['user_id' => $this->id])->sum('count');
        return $count;
    }
    public function cash() {
        $count = Cash::find()->where(['user_id' => $this->id])->sum('count');
        return $count;
    }

}