<?php


namespace App\PaymentMethods;


use App\PaymentMethods\PaymentEntities\Card;
use App\PaymentMethods\PaymentEntities\Phone;
use DateTime;


class Credentials
{
    private Card $card;
    private Phone $phone;

    public function getCard(): Card
    {
        return $this->card;
    }

    public function setCard(string $pan, DateTime $expiryDate, int $cvc, $holder): void
    {
        $this->card = new Card($pan, $expiryDate, $cvc, $holder);
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function setPhone(string $country, string $operator, string $number): void
    {
        $this->phone = new Phone($country, $operator, $number);
    }
}