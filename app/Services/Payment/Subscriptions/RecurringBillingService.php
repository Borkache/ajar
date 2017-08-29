<?php

namespace App\Services\Payment\Subscriptions;

use App\Services\Payment\Invoices\InvoiceGenerator;
use App\Services\Payment\ObjectValues\PaymentContract as PaymentContractObjectValue;
use Mockery\Exception;
use App\Services\Payment\Contracts\PaymentContractContainer;

/**
 * Class RecurringBillingService
 * @package App\Services\Payment\Subscriptions
 */
class RecurringBillingService
{

    /**
     * @var UserSubscriptionsCollector
     */
    protected $userSubscriptionsCollector;

    /**
     * @var PaymentContractContainer
     */
    protected $paymentContractContainer;

    /**
     * @var InvoiceGenerator
     */
    protected $invoiceGenerator;


    /**
     * RecurringBillingService constructor.
     * @param UserSubscriptionsCollector $userSubscriptionsCollector
     * @param InvoiceGenerator $invoiceGenerator
     */
    public function __construct(
        UserSubscriptionsCollector $userSubscriptionsCollector,
        InvoiceGenerator $invoiceGenerator
    ) {
        $this->userSubscriptionsCollector = $userSubscriptionsCollector;
        $this->paymentContractContainer = \App::make('PaymentContractContainer');
        $this->invoiceGenerator = $invoiceGenerator;
    }


    /**
     * @param $userId
     * @return array
     */
    public function generateUserInvoices($userId)
    {
        $userSubscribedContracts = $this->userSubscriptionsCollector->getUserSubscriptions($userId);

        $invoices = [];

        foreach ($userSubscribedContracts as $subscribedContract){
            /** @var \App\Services\Payment\Contracts\CostCalculatorInterface $contractService */
            $contractService = $this->paymentContractContainer->getService($subscribedContract->type);
            $contractData = $contractService->calculateCosts($subscribedContract->id);
            $invoices[] = $this->invoiceGenerator->generateInvoice($contractData);
        }

        return $invoices;


    }
}