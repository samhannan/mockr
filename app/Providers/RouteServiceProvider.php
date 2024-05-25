<?php

namespace App\Providers;

use App\Models\Endpoint;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Route::bind('key', function (string $value) {
            return Endpoint::where('key', $value)->firstOrFail();
        });
    }
}
