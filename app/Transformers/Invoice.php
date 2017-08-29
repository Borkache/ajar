<?php

namespace App\Transformers;

use League\Fractal;
use App\Services\Transformers\RequiredFieldsTrait;

/**
 * Class Ib
 * @package Modules\External\Http\Response\Transformers
 */
class Invoice extends Fractal\TransformerAbstract
{

    /**
     * @param \App\Domain\Models\Invoice $invoice
     * @return array
     */
    public function transform($invoice)
    {

        $invoiceData = [
            'id' => $invoice->id,
            'name' => $invoice->name,
            //.....
        ];



        return $invoiceData;
    }
}