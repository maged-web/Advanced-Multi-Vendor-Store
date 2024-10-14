<?php

namespace App\Providers;

use App\Repositiories\Cart\CartModelRepositories;
use App\Repositiories\Cart\CartRepositories;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(CartRepositories::class,function()
        {
            return new CartModelRepositories();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
