<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once './vendor/autoload.php';

use App\PaymentMethods\Credentials;
use App\Services\Payments\ChargePaymentService;
use App\Services\Payments\Commands\CreatePaymentCommand;
use App\Services\Payments\CreatePaymentService;
use Money\Money;




final class PaymentTest extends TestCase
{
    public function testCanBeCreateCredentials(): void
    {
        $user = $this->buildCredentials();
        $this->assertEquals('+7 (123) 123-45-67', $user->getPhone()->getFullPhone(true));
        $this->assertEquals('4242424242424242', $user->getCard()->getPan());
    }

    public function testFeeCase1():void
    {   // кейс комиссию платит продавец
        $user = $this->buildCredentials();
        $createPaymentService = new CreatePaymentService();
        $payment = $createPaymentService->handle(
            new CreatePaymentCommand(Money::RUB(10000), $user, 'card', 'Sberbank', false)
        );
        $this->assertEquals('10000', $payment->getAmount()->getAmount());
        $this->assertEquals('301', $payment->getCommission()->getAmount());
    }

    public function testFeeCase2():void
    {   // кейс комиссию платит покупатель
        $user = $this->buildCredentials();
        $createPaymentService = new CreatePaymentService();
        $payment = $createPaymentService->handle(
            new CreatePaymentCommand(Money::RUB(10000), $user, 'card', 'Sberbank')
        );
        $this->assertEquals('10311', $payment->getAmount()->getAmount());
        $this->assertEquals('311', $payment->getCommission()->getAmount());
    }



    public function testFeeCase3():void
    {   // минимум 15к для тиньки
        $user = $this->buildCredentials();
        $createPaymentService = new CreatePaymentService();
        $payment = $createPaymentService->handle(
            new CreatePaymentCommand(Money::RUB(15000), $user, 'card', 'Tinkoff')
        );
        $this->assertEquals('15568', $payment->getAmount()->getAmount());
        $this->assertEquals('568', $payment->getCommission()->getAmount());
    }

    public function testFeeCase4():void
    {   // минимум 15к для тиньки
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Something went wrong! try another summ or bank');
        $user = $this->buildCredentials();
        $createPaymentService = new CreatePaymentService();
        $createPaymentService->handle(
            new CreatePaymentCommand(Money::RUB(10000), $user, 'card', 'Tinkoff')
        );
    }

    public function testInvalidPaymentTypeQiwi():void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Something went wrong! selected payment method is not support a card payment');
        $user = $this->buildCredentials();
        $createPaymentService = new CreatePaymentService();
        $payment = $createPaymentService->handle(
            new CreatePaymentCommand(Money::RUB(15000), $user, 'card', 'Qiwi')
        );

        $chargePaymentService = new ChargePaymentService();
        $chargePaymentService->handle($payment);
    }

    public function testNeedNotifyCase1():void
    {
        $user = $this->buildCredentials();
        $createPaymentService = new CreatePaymentService();
        $payment = $createPaymentService->handle(
            new CreatePaymentCommand(Money::EUR(10000), $user, 'card', 'Sberbank')
        );

        $chargePaymentService = new ChargePaymentService();
        $response = $chargePaymentService->handle($payment);

        $this->assertEquals(true, $response->isNeedNotify());
    }

    public function testNeedNotifyCase2():void
    {
        $user = $this->buildCredentials();
        $createPaymentService = new CreatePaymentService();
        $payment = $createPaymentService->handle(
            new CreatePaymentCommand(Money::RUB(2000), $user, 'phone', 'Qiwi')
        );

        $chargePaymentService = new ChargePaymentService();
        $response = $chargePaymentService->handle($payment);

        $this->assertEquals(true, $response->isNeedNotify());
    }

    public function testNeedNotifyCase3():void
    {
        $user = $this->buildCredentials();
        $createPaymentService = new CreatePaymentService();
        $payment = $createPaymentService->handle(
            new CreatePaymentCommand(Money::RUB(10000), $user, 'card', 'Sberbank')
        );

        $chargePaymentService = new ChargePaymentService();
        $response = $chargePaymentService->handle($payment);

        $this->assertEquals(false, $response->isNeedNotify());
    }

    public function testWorkSystem():void
    {
        $user = $this->buildCredentials();
        $createPaymentService = new CreatePaymentService();
        $payment = $createPaymentService->handle(
            new CreatePaymentCommand(Money::RUB(10000), $user, 'card', 'Sberbank')
        );

        $chargePaymentService = new ChargePaymentService();
        $response = $chargePaymentService->handle($payment);
        $this->assertEquals(true, $response->isCompleted());
    }



    private function buildCredentials():Credentials
    {
        $user = new Credentials();
        $user->setCard('4242424242424242', new \DateTime('2021-10-15'), 123, 'GAZIN MAXIM');
        $user->setPhone('+7', '123', '1234567');
        return $user;
    }
}


