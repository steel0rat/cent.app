<?php


namespace App\Banks;

use App\Banks\AbstractBank;
use App\Banks\Responses\Payment;
use Money\Money;
use App\PaymentMethods\Credentials;

class Sberbank extends AbstractBank
{
    public function __construct()
    {
        $this->isCard = true;
        $this->isPhone = true;
    }

    public function createPaymentPhone(Money $amount, Credentials $credentials, bool $needNotify): Payment
    {
        $phone = $credentials->getPhone();
        return new Payment(Payment::STATUS_COMPLETED, $needNotify);
    }

    public function createPaymentCard(Money $amount, Credentials $credentials, bool $needNotify): Payment
    {
        $card = $credentials->getCard();
        return new Payment(Payment::STATUS_COMPLETED, $needNotify);
    }
}