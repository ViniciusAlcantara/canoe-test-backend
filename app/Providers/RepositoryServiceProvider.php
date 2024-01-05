<?php

namespace App\Providers;

use App\Repositories\AliasRepository;
use App\Repositories\Contracts\AliasRepositoryInterface;
use App\Repositories\Contracts\FundRepositoryInterface;
use App\Repositories\FundRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            FundRepositoryInterface::class,
            FundRepository::class
        );
 
        $this->app->singleton(
            AliasRepositoryInterface::class,
            AliasRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
