<?php

namespace App\Providers;

use App\Repositories\AuthorRepository;
use App\Repositories\AuthorRepositoryInterface;
use App\Repositories\BookRepository;
use App\Repositories\BookRepositoryInterface;
use App\Services\BookParser;
use App\Services\BookParserInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            BookRepositoryInterface::class,
            BookRepository::class
        );
        $this->app->bind(
            AuthorRepositoryInterface::class,
            AuthorRepository::class
        );

        $this->app->bind(
            BookParserInterface::class,
            BookParser::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
