<?php

namespace App\Services\Payment\Contracts;

use App\Services\Payment\ObjectValues\PaymentContract as PaymentContractObjectValue;
use Mockery\Exception;

/**
 * Class PaymentContractContainer
 * @package App\Services\Payment\Contracts
 */
class PaymentContractContainer
{

    /**
     * @var array
     */
    protected $availableContractServices;


    /**
     * PaymentContractContainer constructor.
     * @param array $availableContractServices
     */
    public function __construct(
        array $availableContractServices
    ) {
        $this->availableContractServices = $availableContractServices;
    }


    /**
     * @param $contractType
     * @return mixed
     */
    public function getService($contractType)
    {
        if (!in_array($contractType, PaymentContractObjectValue::$allowedTypes) ||
            !isset($this->availableContractServices[$contractType])){
            throw new Exception('Contract type was not found');
        }

        return $this->availableContractServices[$contractType];

    }
}