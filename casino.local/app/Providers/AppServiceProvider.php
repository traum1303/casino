<?php

namespace App\Providers;

use App\Interfaces\GamblingInterface;
use App\Interfaces\RepositoryInterface;
use App\Jobs\ProcessGamblingJob;
use App\Repositories\GamblingHistoryRepository;
use App\Services\GamblingService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(GamblingInterface::class, GamblingService::class);
        $this->app->when(GamblingService::class)
            ->needs(RepositoryInterface::class)
            ->give(GamblingHistoryRepository::class);
        $this->app->when(ProcessGamblingJob::class)
            ->needs(GamblingInterface::class)
            ->give(GamblingService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
