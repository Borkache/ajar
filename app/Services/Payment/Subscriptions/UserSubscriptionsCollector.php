<?php

namespace App\Services\Payment\Subscriptions;

use App\Services\Payment\ObjectValues\PaymentContract as PaymentContractObjectValue;
use Mockery\Exception;
use App\Services\Payment\Contracts\PaymentContractContainer;

/**
 * Class UserSubscriptionsCollector
 * @package App\Services\Payment\Subscriptions
 */
class UserSubscriptionsCollector
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
     * Get validators by payment name and email
     * @param $paymentName
     * @param $email
     * @return mixed
     */
    public function getUserSubscriptions($userId)
    {

    }
}