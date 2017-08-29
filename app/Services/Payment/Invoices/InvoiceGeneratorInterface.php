<?php

namespace App\Services\Payment\Invoices;

use App\Services\Payment\ObjectValues\PaymentContract as PaymentContractObjectValue;
use Mockery\Exception;

/**
 * Interface InvoiceGeneratorInterface
 * @package App\Services\Payment\Invoices
 */
interface InvoiceGeneratorInterface
{

    public function generateInvoice($id);
}