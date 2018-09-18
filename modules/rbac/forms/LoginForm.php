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
class LoginForm extends Model
{
    public $username;
    public $rememberMe = true;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username',], 'required'],
            ['rememberMe', 'boolean'],
        ];
    }
}
