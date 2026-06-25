<?php

namespace App\Providers;

use App\Models\Category;
use App\Services\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Cart::class, fn () => new Cart());
    }

    public function boot(): void
    {
        View::composer(['storefront.*', 'layouts.*'], function ($view) {
            $cart = app(Cart::class);
            $view->with('cartCount', $cart->count());

            try {
                if (! View::shared('navCategories')) {
                    View::share('navCategories', Category::orderBy('name')->get());
                }
            } catch (\Throwable $e) {
                View::share('navCategories', collect());
            }
        });
    }
}
