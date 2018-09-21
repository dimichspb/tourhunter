<?php

namespace app\modules\api\models;

class User extends \app\models\user\User
{
    /**
     * Disable some fields from index
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'username',
        ];
    }
}