<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Payment\Subscriptions\RecurringBillingService;
use Illuminate\Support\Facades\Auth;
use App\Services\Respondent;

/**
 * Class InvoiceController
 * @package App\Http\Controllers\Auth
 */
class InvoiceController extends Controller
{

    /**
     * @var Respondent
     */
    protected $respondent;

    /**
     * InvoiceController constructor.
     * @param Respondent $respondent
     */
    public function __construct(Respondent $respondent)
    {
        $this->respondent = $respondent;
    }

    /**
     * @param RecurringBillingService $recurringBillingService
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateUserInvoices(RecurringBillingService $recurringBillingService)
    {
        $invoices = $recurringBillingService->generateUserInvoices(Auth::id());

        return $this->respondent->respondCollection(collect([$invoices]), new Transformers\Invoice());
    }

}
