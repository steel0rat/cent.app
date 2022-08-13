<?php


namespace App\Banks;


use App\Banks\Responses\Payment;
use Money\Money;
use App\PaymentMethods\Credentials;

abstract class AbstractBank
{
    protected string $isCard;
    protected string $isPhone;

    public function IsCard():bool
    {
        return $this->isCard;
    }
    public function IsPhone():bool
    {
        return $this->isPhone;
    }

    abstract function createPaymentCard(Money $amount, Credentials $credentials, bool $needNotify):Payment;

    abstract function createPaymentPhone(Money $amount, Credentials $credentials, bool $needNotify):Payment;

}