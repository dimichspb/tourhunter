<?php

namespace app\modules\api\models;

class User extends \app\models\user\User
{
    public function fields()
    {
        return [
            'id',
            'username',
        ];
    }
}