<?php

namespace App\Services\Payment\Contracts\CommunalPayments\Electricity\Provider;

use App\Services\Payment\Contracts\CostCalculatorInterface;
use App\Services\Payment\ObjectValues\PaymentContract as PaymentContractObjectValue;
use Mockery\Exception;

/**
 * Get data from electricity provider API
 * Class Client
 * @package App\Services\Payment\Contracts\CommunalPayments\Electricity\Provider
 */
class Client
{

    /**
     * @var array
     */
    protected $httpClient;


    /**
     * Client constructor.
     * @param $httpClient
     */
    public function __construct(
        $httpClient
    ) {
        $this->httpClient = $httpClient;
    }


    public function getClientData($userData)
    {
        //make some http requests as example

    }
}