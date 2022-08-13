<?php


namespace App\Entities;

use DateTime;
use Money\Money;
use App\PaymentMethods\Credentials;


class Payment
{

    private Money $amount;
    private Money $commission;
    private Credentials $cred;
    private DateTime $createdAt;
    private $type;
    private $bank;
    private bool $notify;

    public function __construct(Money $amount, Money $commission, Credentials $cred, $type, $bank, bool $notify)
    {
        $this->amount     = $amount;
        $this->commission = $commission;
        $this->cred       = $cred;
        $this->createdAt  = new DateTime();
        $this->type       = $type;
        $this->bank       = $bank;
        $this->notify     = $notify;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getCommission(): Money
    {
        return $this->commission;
    }

    public function getCred(): Credentials
    {
        return $this->cred;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getNetAmount(): Money
    {
        return $this->amount->subtract($this->commission);
    }

    public function getType()
    {
        return $this->type;
    }

    public function getBank()
    {
        return $this->bank;
    }

    public function getNotify(): bool
    {
        return $this->notify;
    }

}