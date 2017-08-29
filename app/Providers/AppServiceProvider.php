<?php

namespace App\Providers;

use App\Services\Payment\Contracts\CommunalPayments\Electricity\CostCalculator;
use App\Services\Payment\Contracts\PaymentContractContainer;
use Illuminate\Support\ServiceProvider;
use App\Services\Payment\ObjectValues\PaymentContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind('PaymentContractsContainer', function($app)
        {
            return new PaymentContractContainer(
                [
                    PaymentContract::TYPE_RENT => $app->make('\App\Services\Payment\Contracts\CommunalPayments\Electricity\CostCalculator'),
                    PaymentContract::TYPE_ELECTRICITY => $app->make('\App\Services\Payment\Contracts\CommunalPayments\Electricity\CostCalculator'),
                ]
            );
        });



    }
}
