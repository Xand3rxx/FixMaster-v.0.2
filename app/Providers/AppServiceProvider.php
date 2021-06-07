<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
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

        view()->composer('layouts.client', function ($view) {

            $view->with([
                'myWallet'  =>  WalletTransaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get(),
                'profile'   =>  auth()->user()->account,
            ]);
        });

        view()->composer('layouts.dashboard', function ($view) {

            $view->with([
                'profile'   =>  auth()->user()->account,
                'pendingRequests'   => \App\Models\ServiceRequest::PendingRequests()->get()->count(),
                'unresolvedWarranties'  =>  \App\Models\ServiceRequestWarranty::UnresolvedWarranties()->get()->count(),
                'newQuotes' =>  \App\Models\Rfq::PendingQuotes()->get()->count(),

            ]);
        });

        view()->composer('layouts.partials._cse_sidebar', function ($view) {
            $view->with([
                'cse_availability' => \App\Models\Cse::isAvailable() ? ['Available', 'checked'] : ['Unavailable', ''],
                'unresolvedWarranties'  => \App\Models\ServiceRequestAssigned::with('service_request_warranty', 'user.account', 'service_request')->where(['user_id' => auth()->user()->id, 'status' => 'Active'])->get(),
            ]);
        });

        // view()->composer('layouts.partials._supplier_sidebar', function ($view) {
        //     $view->with([
        //         'newQuotes' =>  \App\Models\Rfq::PendingQuotes()->get()->count(),
        //     ]);
        // });
    }
}
