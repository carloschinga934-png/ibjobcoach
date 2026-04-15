<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('*', function ($view) {
            $locale = session('lang', 'es_PE');
            $langFile = resource_path("lang/{$locale}.php");

            $lang = file_exists($langFile)
                ? include $langFile
                : include resource_path("lang/es_PE.php");

            $view->with('lang', $lang);
        });


    }
}
