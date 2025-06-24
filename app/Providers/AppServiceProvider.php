<?php

namespace App\Providers;

use App\Repositories\LineRepository;
use App\Repositories\LineRepositoryInterface;
use App\Repositories\StopRepository;
use App\Repositories\StopRepositoryInterface;
use App\Repositories\TransRepository;
use App\Repositories\TransRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TransRepositoryInterface::class, TransRepository::class);
        $this->app->bind(StopRepositoryInterface::class, StopRepository::class);
        $this->app->bind(LineRepositoryInterface::class, LineRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
