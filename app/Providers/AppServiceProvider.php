<?php

namespace App\Providers;


use App\Printers\{DataNikahPrinter,DataN6Printer};
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton('DataNikahPrinter', function () {
            return new DataNikahPrinter();
        });

        $this->app->singleton('DataN6Printer', function () {
            return new DataN6Printer();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
          Schema::defaultStringLength(191);
        App::setLocale('id');
        config(['app.locale' => 'id']);

    }
}
