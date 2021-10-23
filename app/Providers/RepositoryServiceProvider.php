<?php

namespace App\Providers;

use App\Interfaces\Auth\AuthUserRepositoryInterface;
use App\Interfaces\Categories\CategoryRepositoryInterface;
use App\Interfaces\Movies\MovieRepositoryInterface;
use App\Interfaces\Plans\PlanRepositoryInterface;
use App\Interfaces\Reviews\ReviewRepositoryInterface;
use App\Repositories\Auth\AuthUserRepository;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Movies\MovieRepository;
use App\Repositories\Plans\PlanRepository;
use App\Repositories\Reviews\ReviewRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthUserRepositoryInterface::class, AuthUserRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
