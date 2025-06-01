<?php

namespace App\Providers;

use App\Services\Pdf\PdfServiceInterface;
use App\Services\Pdf\src\PdfService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        PdfServiceInterface::class => PdfService::class,
    ];

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
        //
    }
}
