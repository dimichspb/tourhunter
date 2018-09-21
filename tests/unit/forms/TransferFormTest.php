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

    /**
     * Before tests
     */
    public function _before()
    {
        $this->model = new User();
        $this->model->username = 'user1';
        $this->model->generateAuthKey();
        $this->model->generateAccessToken();
        $this->model->save();
    }

    /**
     * After tests
     */
    public function _after()
    {
        User::deleteAll();
    }

    /**
     * Test validate sender_id success
     */
    public function testValidateSenderIdSuccess()
    {
        $form = new TransferForm();
        $form->sender_id = $this->model->id;

        $form->validate();

        expect($form->hasErrors('sender_id'))->false();
    }

    /**
     * Test validate sender_id empty failed
     */
    public function testValidateSenderIdEmptyFailed()
    {
        $form = new TransferForm();
        $form->sender_id = null;

        $form->validate();

        expect($form->hasErrors('sender_id'))->true();
    }

    /**
     * Test validate sender_id not exists failed
     */
    public function testValidateSenderIdNotExistFailed()
    {
        $form = new TransferForm();
        $form->sender_id = 0;

        $form->validate();

        expect($form->hasErrors('sender_id'))->true();
    }

    /**
     * Test validate sender_id string failed
     */
    public function testValidateSenderIdStringFailed()
    {
        $form = new TransferForm();
        $form->sender_id = 'this is not an integer';

        $form->validate();

        expect($form->hasErrors('sender_id'))->true();
    }

    /**
     * Test validate reciepient id success
     */
    public function testValidateReciepientIdSuccess()
    {
        $form = new TransferForm();
        $form->reciepient_id = $this->model->id;

        $form->validate();

        expect($form->hasErrors('reciepient_id'))->false();
    }

    /**
     * Test validate reciepient id empty failed
     */
    public function testValidateReciepientIdEmptyFailed()
    {
        $form = new TransferForm();
        $form->reciepient_id = null;

        $form->validate();

        expect($form->hasErrors('reciepient_id'))->true();
    }

    /**
     * Test validate reciepient id not exists failed
     */
    public function testValidateReciepientIdNotExistFailed()
    {
        $form = new TransferForm();
        $form->reciepient_id = 0;

        $form->validate();

        expect($form->hasErrors('reciepient_id'))->true();
    }

    /**
     * Test validate reciepient id string failed
     */
    public function testValidateReciepientIdStringFailed()
    {
        $form = new TransferForm();
        $form->reciepient_id = 'this is not an integer';

        $form->validate();

        expect($form->hasErrors('reciepient_id'))->true();
    }

    /**
     * Test amount success
     */
    public function testAmountSuccess()
    {
        $form = new TransferForm();
        $form->sender_id = $this->model->id;
        $form->amount = 100;

        $form->validate();

        expect($form->hasErrors('amount'))->false();
    }

    /**
     * Test amount too less failed
     */
    public function testAmountTooLessFailed()
    {
        $form = new TransferForm();
        $form->sender_id = $this->model->id;
        $form->amount = -100;

        $form->validate();

        expect($form->hasErrors('amount'))->true();
    }

    /**
     * Test amount too much failed
     */
    public function testAmountTooMuchFailed()
    {
        $form = new TransferForm();
        $form->sender_id = $this->model->id;
        $form->amount = 2000;

        $form->validate();

        expect($form->hasErrors('amount'))->true();
    }
}