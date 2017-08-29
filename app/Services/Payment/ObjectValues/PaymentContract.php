<?php

namespace App\Services\Payment\ObjectValues;


/**
 * Class PaymentContractContainer
 * @package App\Services\Payment\Contracts
 */
class PaymentContract
{

    const TYPE_RENT = 'rent';
    const TYPE_ELECTRICITY = 'rent';

    public static $allowedTypes = [
        self::TYPE_ELECTRICITY,
        self::TYPE_RENT,
    ];




}