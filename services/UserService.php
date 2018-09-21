<?php
namespace app\services;

use app\exceptions\NotFoundException;
use app\exceptions\TransferException;
use app\forms\user\TransferForm;
use app\models\user\User;
use yii\base\Module;
use yii\db\Connection;

class UserService
{
    /**
     * @var Connection
     */
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function transfer(TransferForm $form)
    {
        $sender = User::findOne($form->sender_id);
        $reciepient = User::findOne($form->reciepient_id);

        if (is_null($sender)) {
            throw new NotFoundException(\Yii::t('app', 'Sender not found'));
        }

        if (is_null($reciepient)) {
            throw new NotFoundException(\Yii::t('app', 'Reciepient not found'));
        }

        $transaction = $this->connection->beginTransaction();

        try {
            $this->performTransfer($sender, $reciepient, $form->amount);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    protected function performTransfer(User $sender, User $reciepient, $amount)
    {
        $sender->decreaseBalance($amount);
        $reciepient->increaseBalance($amount);

        if (!$sender->save()) {
            $errorString = implode(PHP_EOL, $sender->errors);
            throw new TransferException('Error saving Sender model: ' . $errorString);
        }

        if (!$reciepient->save()) {
            $errorString = implode(PHP_EOL, $reciepient->errors);
            throw new TransferException('Error saving Reciepient model: ' . $errorString);
        }
    }
}