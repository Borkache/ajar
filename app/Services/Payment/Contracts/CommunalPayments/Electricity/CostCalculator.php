<?php

namespace App\Services\Payment\Contracts\CommunalPayments\Electricity;

use App\Services\Payment\Contracts\CostCalculatorInterface;
use App\Services\Payment\ObjectValues\PaymentContract as PaymentContractObjectValue;
use Mockery\Exception;
use App\Services\Payment\Contracts\CommunalPayments\Electricity\Provider\Client as ProviderApiClient;

/**
 * Class PaymentContractContainer
 * @package App\Services\Payment\Contracts
 */
class CostCalculator implements CostCalculatorInterface
{

    /**
     * @var ProviderApiClient
     */
    protected $apiClient;


    /**
     * CostCalculator constructor.
     * @param ProviderApiClient $apiClient
     */
    public function __construct(
        ProviderApiClient $apiClient
    ) {
        $this->apiClient = $apiClient;
    }


    public function calculateCosts($id)
    {
        $collectedData = $this->apiClient->getClientData($id);

    }
}