<?php

namespace app\forms;

use app\models\user\User;
use Yii;
use yii\base\Model;

/**
 * TransferForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class TransferForm extends Model
{
    public $user_id;
    public $amount;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['user_id', 'amount'], 'required'],
            [['user_id'], 'integer'],
            [['amount',], 'decimal'],
        ];
    }
}
