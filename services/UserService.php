<?php
namespace app\services;

use app\forms\user\TransferForm;
use app\models\user\User;

class UserService
{
    public function transfer(User $from, TransferForm $form)
    {
        return true;
    }
}