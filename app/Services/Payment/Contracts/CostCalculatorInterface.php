<?php

namespace App\Services\Payment\Contracts;

use App\Services\Payment\ObjectValues\PaymentContract as PaymentContractObjectValue;
use Mockery\Exception;

/**
 * Class PaymentContractContainer
 * @package App\Services\Payment\Contracts
 */
interface CostCalculatorInterface
{

    public function calculateCosts($id);
}