<?php

namespace app\modules\rbac\forms;

use app\models\user\User;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $username;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username',], 'required'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        return Yii::$app->user->login($this->createUser(), 3600*24*30);
    }

    /**
     * Creates User
     *
     * @return User|null
     */
    public function createUser()
    {
        $user = new User(['
            username' => $this->username
        ]);
        if (!$user->save()) {
            throw new \RuntimeException('Can not create user');
        }
        return $user;
    }
}
