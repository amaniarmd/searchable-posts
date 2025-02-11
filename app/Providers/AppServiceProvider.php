<?php

namespace App\Providers;

use App\Models\Post;
use App\Observers\PostObserver;
use App\Repository\ElasticSearch\Classes\ElasticSearchRepository;
use App\Repository\Post\Classes\PostRepository;
use App\Repository\ElasticSearch\Interfaces\ElasticSearchRepositoryInterface;
use App\Repository\Post\Interfaces\PostRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(ElasticSearchRepositoryInterface::class, ElasticSearchRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Post::observe(PostObserver::class);
    }
}
