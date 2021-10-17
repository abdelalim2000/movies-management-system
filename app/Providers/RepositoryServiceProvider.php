<?php

namespace App\Providers;

use App\Interfaces\Auth\AuthUserRepositoryInterface;
use App\Interfaces\Categories\CategoryRepositoryInterface;
use App\Interfaces\Movies\MovieRepositoryInterface;
use App\Repositories\Auth\AuthUserRepository;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Movies\MovieRepository;
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
