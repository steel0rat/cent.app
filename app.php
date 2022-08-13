<?php

use App\PaymentMethods\Credentials;
use App\Services\Payments\ChargePaymentService;
use App\Services\Payments\Commands\CreatePaymentCommand;
use App\Services\Payments\CreatePaymentService;
use Money\Money;
use App\Notify\Notify;
use App\Logger\Logger;

require_once './vendor/autoload.php';


//заводим клиента и его данные
$user = new Credentials();
try {
    $user->setCard('4242424242424242', new \DateTime('2021-10-15'), 123, 'GAZIN MAXIM');
} catch (Exception $e) {
    sendResponse("Something went wrong! Try another card", 500);
}

try {
    $user->setPhone('+7', '123', '1234567');
} catch (Exception $e) {
    sendResponse("Something went wrong! Try another phone", 500);
}

try {
    //собираем платёж
    $createPaymentService = new CreatePaymentService();
    $payment = $createPaymentService->handle(
        new CreatePaymentCommand(Money::RUB(15000), $user, 'card', 'Tinkoff')
    );

    //выполняем платёж
    $chargePaymentService = new ChargePaymentService();
    $response = $chargePaymentService->handle($payment);

    $looger = new Logger();
    $looger->log($payment, $response);
    if ($response->isCompleted()) {
        if($response->isNeedNotify()) {
            $notifier = new Notify();
            $notifier->sendMessage($payment);
        }
        sendResponse('Thank you! Payment completed', 200);
    } elseif ($response->isFailed()) {
        sendResponse('Something went wrong! Try another card', 500);
    }
} catch (Exception $e) {
    sendResponse($e->getMessage(), 500);
}


function sendResponse($msg, int $code) {
    http_response_code($code);
    echo $msg;
    echo PHP_EOL;
}