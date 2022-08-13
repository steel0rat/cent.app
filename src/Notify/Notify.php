<?php


namespace App\Notify;


use App\Entities\Payment;

class Notify
{
    public function sendMessage(Payment $payment)
    {
        ##тут логика обработки уведомления об успешном платеже
    }
}