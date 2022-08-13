<?php


namespace App\PaymentMethods\PaymentEntities;


class Phone
{

    private string $country;
    private string $operator;
    private string $number;

    public function __construct(string $country, string $operator, string $number)
    {
        $this->country = $country;
        $this->operator = $operator;
        $this->number = $number;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getFullPhone($pretty = false): string
    {
        if ($pretty) {
            return $this->country ." ($this->operator) " .
                   substr($this->number, 0, 3) . "-" .
                   substr($this->number, 3, 2) . "-" .
                   substr($this->number, -2);
        }
        return $this->country . $this->operator . $this->number;
    }

}