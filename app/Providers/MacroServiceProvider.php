<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerBlameableMacro();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    public function registerBlameableMacro(): void
    {
        Blueprint::macro('blames', function () {
            $this->unsignedBigInteger('created_by')->nullable();
            $this->unsignedBigInteger('updated_by')->nullable();
            $this->unsignedBigInteger('deleted_by')->nullable();

            $this->foreign('created_by')->references('id')->on('users');
            $this->foreign('updated_by')->references('id')->on('users');
            $this->foreign('deleted_by')->references('id')->on('users');
        });
    }
}
