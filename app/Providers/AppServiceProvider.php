<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        // Daftarkan route web
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // Gunakan view custom untuk semua pagination
        Paginator::defaultView('vendor.pagination.custom');
    }
}
