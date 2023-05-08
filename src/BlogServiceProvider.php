<?php

namespace Locomotif\Blog;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Locomotif\Blog\Controller\BlogController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/Routes/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'blog');
        $this->loadViewsFrom(__DIR__.'/views/categories',    'blogCategories');
        $this->loadViewsFrom(__DIR__.'/views/subcategories', 'blogSubcategories');

        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/locomotif/blog'),
        ]);
        
    }
}
