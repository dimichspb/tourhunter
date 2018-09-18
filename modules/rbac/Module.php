<?php

namespace app\modules\rbac;

use app\models\user\User;
use app\modules\rbac\forms\LoginForm;
use app\modules\rbac\forms\RegisterForm;
use yii\web\Application;
use yii\web\Session;

/**
 * rbac module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\rbac\controllers';

    protected $session;
    protected $user;

    public function __construct($id, \yii\base\Module $parent = null, Session $session, array $config = [])
    {
        $this->session = $session;
        $this->user = $parent->user;

        parent::__construct($id, $parent, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /**
     * Logs in a user using the provided username and password.
     * @param RegisterForm $form
     * @return bool whether the user is logged in successfully
     */
    public function register(RegisterForm $form)
    {
        if (!$form->validate()) {
            return false;
        }

        $user = $this->createUser($form->username);

        if ($user->hasErrors()) {
            foreach ($user->errors as $attribute => $errors) {
                $errorString = implode("\n", $errors);
                $this->session->addFlash('warning', $attribute . ', errors ' . $errorString);
            }
            return false;
        }

        return $this->user->login($user, 3600*24*30);
    }

    /**
     * Creates User
     *
     * @param $username
     * @return User|null
     */
    public function createUser($username)
    {
        $user = new User();
        $user->username = $username;
        $user->generateAuthKey();
        $user->generateAccessToken();

        $user->save();

        return $user;
    }

    /**
     * Logs in a user using the provided username and password.
     * @param LoginForm $form
     * @return bool whether the user is logged in successfully
     */
    public function login(LoginForm $form)
    {
        if (!$form->validate()) {
            return false;
        }

        $user = $this->getUser($form->username);

        if (!$user) {
            $this->session->addFlash('warning', 'User not found');
            return false;
        }

        return $this->user->login($this->getUser($form->username), $form->rememberMe ? 3600*24*30 : 0);
    }

    /**
     * Finds user by [[username]]
     *
     * @param $username
     * @return User|null
     */
    public function getUser($username)
    {
        return User::findByUsername($username);
    }
}
