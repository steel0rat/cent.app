<?php


namespace App\Banks;

use App\Banks\AbstractBank;
use App\Banks\Responses\Payment;
use Money\Money;
use App\PaymentMethods\Credentials;

class Qiwi extends AbstractBank
{
    public function __construct()
    {
        $this->isCard = false;
        $this->isPhone = true;
    }

    public function createPaymentPhone(Money $amount, Credentials $credentials, bool $needNotify): Payment
    {
        $phone = $credentials->getPhone();
        return new Payment(Payment::STATUS_COMPLETED, $needNotify);
    }

    public function createPaymentCard(Money $amount, Credentials $credentials, bool $needNotify): Payment
    {
        // при моём методе необходимо писать заглушки
        return new Payment(Payment::STATUS_FAILED, $needNotify);
    }
}