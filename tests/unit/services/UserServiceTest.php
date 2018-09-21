<?php
namespace app\tests\unit\services;

use app\forms\user\TransferForm;
use app\models\user\User;
use app\services\UserService;
use Codeception\Test\Unit;

class UserServiceTest extends Unit
{
    /**
     * @var User
     */
    protected $sender;

    /**
     * @var User
     */
    protected $reciepient;
    
    public function _before()
    {
        $this->sender = new User();
        $this->sender->username = 'user1';
        $this->sender->generateAuthKey();
        $this->sender->generateAccessToken();
        $this->sender->save();

        $this->reciepient = new User();
        $this->reciepient->username = 'user2';
        $this->reciepient->generateAuthKey();
        $this->reciepient->generateAccessToken();
        $this->reciepient->save();
    }
    
    public function _after()
    {
        User::deleteAll();
    }

    public function testTransferSuccess()
    {
        /** @var TransferForm $transferForm */
        $transferForm = $this->getTransferFormMock($this->sender, $this->reciepient, $amount = 100);

        /** @var UserService $service */
        $service = \Yii::$container->get(UserService::class);

        $senderBalanceBefore = $this->sender->balance;
        $reciepientBalanceBefore = $this->reciepient->balance;

        $service->transfer($transferForm);

        $sender = User::findIdentity($this->sender->id);
        $reciepient = User::findIdentity($this->reciepient->id);

        expect($sender->balance)->equals($senderBalanceBefore - $amount);
        expect($reciepient->balance)->equals($reciepientBalanceBefore + $amount);
    }

    protected function getTransferFormMock(User $sender, User $reciepient, $amount)
    {
        $mock = $this->getMockBuilder(TransferForm::class)->getMock();
        $mock->sender_id = $sender->id;
        $mock->reciepient_id = $reciepient->id;
        $mock->amount = $amount;

        return $mock;
    }
}