<?php
namespace app\tests\unit\forms;

use app\forms\user\TransferForm;
use app\models\user\User;
use Codeception\Test\Unit;

class TransferFormTest extends Unit
{
    /**
     * @var User
     */
    protected $model;

    public function _before()
    {
        $this->model = new User();
        $this->model->username = 'user1';
        $this->model->generateAuthKey();
        $this->model->generateAccessToken();
        $this->model->save();
    }

    public function _after()
    {
        User::deleteAll();
    }

    public function testValidateSenderIdSuccess()
    {
        $form = new TransferForm();
        $form->sender_id = $this->model->id;

        $form->validate();

        expect($form->hasErrors('sender_id'))->false();
    }

    public function testValidateSenderIdEmptyFailed()
    {
        $form = new TransferForm();
        $form->sender_id = null;

        $form->validate();

        expect($form->hasErrors('sender_id'))->true();
    }

    public function testValidateSenderIdNotExistFailed()
    {
        $form = new TransferForm();
        $form->sender_id = 0;

        $form->validate();

        expect($form->hasErrors('sender_id'))->true();
    }

    public function testValidateSenderIdStringFailed()
    {
        $form = new TransferForm();
        $form->sender_id = 'this is not an integer';

        $form->validate();

        expect($form->hasErrors('sender_id'))->true();
    }

    public function testValidateReciepientIdSuccess()
    {
        $form = new TransferForm();
        $form->reciepient_id = $this->model->id;

        $form->validate();

        expect($form->hasErrors('reciepient_id'))->false();
    }

    public function testValidateReciepientIdEmptyFailed()
    {
        $form = new TransferForm();
        $form->reciepient_id = null;

        $form->validate();

        expect($form->hasErrors('reciepient_id'))->true();
    }

    public function testValidateReciepientIdNotExistFailed()
    {
        $form = new TransferForm();
        $form->reciepient_id = 0;

        $form->validate();

        expect($form->hasErrors('reciepient_id'))->true();
    }

    public function testValidateReciepientIdStringFailed()
    {
        $form = new TransferForm();
        $form->reciepient_id = 'this is not an integer';

        $form->validate();

        expect($form->hasErrors('reciepient_id'))->true();
    }

    public function testAmountSuccess()
    {
        $form = new TransferForm();
        $form->sender_id = $this->model->id;
        $form->amount = 100;

        $form->validate();

        expect($form->hasErrors('amount'))->false();
    }

    public function testAmountTooLessFailed()
    {
        $form = new TransferForm();
        $form->sender_id = $this->model->id;
        $form->amount = -100;

        $form->validate();

        expect($form->hasErrors('amount'))->true();
    }

    public function testAmountTooMuchFailed()
    {
        $form = new TransferForm();
        $form->sender_id = $this->model->id;
        $form->amount = 2000;

        $form->validate();

        expect($form->hasErrors('amount'))->true();
    }
}