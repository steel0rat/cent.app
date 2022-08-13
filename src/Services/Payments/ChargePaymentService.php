<?php


namespace App\Services\Payments;


use App\Banks\Sberbank;
use App\Entities\Payment;
use \App\Banks\Responses\Payment as PaymentResponse;
use Exception;

class ChargePaymentService
{
    public function handle(Payment $payment): PaymentResponse
    {
        try {
            $name = 'App\Banks\\'.$payment->getBank();
            $bank = new $name();
        } catch (Exception $e) {
            throw new Exception('Something went wrong! Try payment method');
        }

        switch ($payment->getType()) {
            case 'card':
                if ($bank->IsCard()) {
                    return $bank->createPaymentCard($payment->getAmount(), $payment->getCred(), $payment->getNotify());
                }
                throw new Exception('Something went wrong! selected payment method is not support a card payment');
            case 'phone':
                if ($bank->IsPhone()) {
                    return $bank->createPaymentPhone($payment->getAmount(), $payment->getCred(), $payment->getNotify());
                }
                throw new Exception('Something went wrong! selected payment method is not support a phone payment');
        }
    }
}