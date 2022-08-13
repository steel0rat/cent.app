<?php


namespace App\Logger;


use App\Entities\Payment;
use \App\Banks\Responses\Payment as PaymentResponse;

class Logger
{
    public function log(Payment $payment, PaymentResponse $status)
    {
        ##тут логика обработки лога, присылаются все данные о платеже и статус
    }
}