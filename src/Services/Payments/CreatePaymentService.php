<?php

namespace App\Services\Payments;

use App\Entities\Payment;
use App\Services\Payments\Commands\CreatePaymentCommand;
use Money\Money;
use App\DatabaseStub\DbStub;
use Exception;

class CreatePaymentService
{
    private $db;

    public function __construct()
    {
        $this->db = new DbStub();
    }
    public function handle(CreatePaymentCommand $command): Payment
    {
        $rules = $this->db->where(
            [
                'Bank' => $command->getPaymentBank(),
                'Cur'  => $command->getAmount()->getCurrency()->getCode()
            ]
        );

        $amount = (int)$command->getAmount()->getAmount();
        $fee = $this->findFee($rules, $amount);

        if ($fee) {
            $feeSums = [$fee['FeeMin']];
            if ($command->isClientFeePayer()){
                $newSumm = ceil(($amount + $fee['FeeFix']) / (1 - $fee['Fee']/100));

                $cur = $command->getAmount()->getCurrency()->getCode();
                $command->setAmount(Money::$cur($newSumm));
                $feeSums[] = $newSumm - $amount;
            } else {
                $feeSums[] = ceil(($amount / 100) * $fee['Fee'] + $fee['FeeFix']);
            }
            $commission = Money::RUB(max($feeSums));

            return new Payment($command->getAmount(), $commission, $command->getCred(), $command->getPaymentType(), $command->getPaymentBank(), $fee['Notify']);
        }
        throw new Exception('Something went wrong! try another summ or bank');
    }

    private function findFee(array $rules, int $amount)
    {
        foreach ($rules as $rule) {
            if ($rule['Left'] <= $amount && $rule['Right'] >= $amount){
                return $rule;
            }
        }
        return false;
    }
}