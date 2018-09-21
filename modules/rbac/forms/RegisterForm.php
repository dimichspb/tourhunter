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
    /**
     * @var string
     */
    public $username;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username',], 'required'],
            [['username'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'username']
        ];
    }
}
