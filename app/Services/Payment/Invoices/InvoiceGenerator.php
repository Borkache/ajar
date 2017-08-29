<?php

namespace App\Services\Payment\Invoices;

use App\Domain\Models\Invoice;
use App\Services\Payment\ObjectValues\PaymentContract as PaymentContractObjectValue;
use Mockery\Exception;

/**
 * Class InvoiceGenerator
 * @package App\Services\Payment\Invoices
 */
class InvoiceGenerator implements InvoiceGeneratorInterface
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
     * @param $invoiceData
     * @return Invoice
     */
    public function generateInvoice($invoiceData)
    {

        //some required fields
        $invoice = new Invoice();
        return $invoice;
    }
}