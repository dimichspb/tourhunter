<?php

namespace app\forms\user;

use app\models\user\User;
use app\validators\AmountValidator;
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
    const MAX_DEBT = 1000;

    public $sender_id;
    public $reciepient_id;
    public $amount;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['sender_id', 'reciepient_id', 'amount'], 'required'],
            [['sender_id', 'reciepient_id',], 'integer'],
            [['sender_id', 'reciepient_id'], 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
            [
                'reciepient_id',
                'compare',
                'compareAttribute' => 'sender_id',
                'operator' => '!=',
                'type' => 'number',
                'message' => \Yii::t('app', 'It is not allowed to transfer money to yourself'),
            ],
            [
                'amount',
                AmountValidator::class,
                'when' => function($model) {
                    return !is_null(User::findOne($model->sender_id));
                },
                'min' => 1,
                'max' => ($user = User::findOne($this->sender_id))? ($user->balance + self::MAX_DEBT): self::MAX_DEBT,
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'sender_id' => 'Sender',
            'reciepient_id' => 'Reciepient',
            'amount' => 'Amount to transfer',
        ];
    }

    /**
     * Clear form
     */
    public function clear()
    {
        $this->sender_id = null;
        $this->reciepient_id = null;
        $this->amount = null;
    }
}
