<?php


namespace App\Services\Payments\Commands;


use Money\Money;
use App\PaymentMethods\Credentials;

class CreatePaymentCommand
{

    private Money $amount;
    private Credentials $cred;
    private $paymentType;
    private $paymentBank;
    private bool $isClientFeePayer;

    public function __construct(Money $amount, Credentials $cred, $paymentType, $paymentBank, $isClientFeePayer = True)
    {
        $this->amount           = $amount;
        $this->cred             = $cred;
        $this->paymentType      = $paymentType;
        $this->paymentBank      = $paymentBank;
        $this->isClientFeePayer = $isClientFeePayer;
    }

    public function setAmount(Money $amount): void
    {
        $this->amount = $amount;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getCred(): Credentials
    {
        return $this->cred;
    }

    public function getPaymentType()
    {
        return $this->paymentType;
    }

    public function getPaymentBank()
    {
        return $this->paymentBank;
    }

    public function isClientFeePayer()
    {
        return $this->isClientFeePayer;
    }

}