<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Auth;
use App\Models\WalletTransaction;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('layouts.client', function($view){

            $view->with([
                'myWallet'  =>  WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get(),
                'profile'   =>  Auth::user()->account,
            ]);
        });

        
    }
}
