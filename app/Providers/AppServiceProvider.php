<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Gunakan Bootstrap pagination
        Paginator::useBootstrapFive();

        // Set locale Carbon ke Indonesia
        Carbon::setLocale('id');
    }
}
