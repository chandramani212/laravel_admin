<?php

namespace App\Providers;

use App\Order;
use App\OrderHistory;
use App\Http\Controllers\OrderHistory;
use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    protected $defer = true;

    public function boot()
    {
        //
        Order::created(function ($order) {
            if ( ! $order->isValid()) {
                return false;
            }else{

                $orderHistory = new OrderHistoryController;
                $orderHistory->store($request);
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
         $this->app->singleton(Order::class, function ($app) {
            return new Ordder();
        });
    }


     public function provides()
    {
        return [Order::class];
    }

}
