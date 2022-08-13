<?php


namespace App\PaymentMethods\PaymentEntities;


use DateTime;

class Card
{

    private string $pan;
    private DateTime $expiryDate;
    private int $cvc;
    private string $holder;

    public function __construct(string $pan, DateTime $expiryDate, int $cvc, string $holder)
    {
        $this->pan        = $pan;
        $this->expiryDate = $expiryDate;
        $this->cvc        = $cvc;
        $this->holder     = $holder;
    }

    public function getPan(): string
    {
        return $this->pan;
    }

    public function getExpiryDate(): DateTime
    {
        return $this->expiryDate;
    }

    public function getCvc(): int
    {
        return $this->cvc;
    }

    public function getHolder(): string
    {
        return $this->holder;
    }

}