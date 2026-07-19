<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Wishlist;
use App\Observers\UserObserver;
use App\Observers\UserDetailObserver;
use App\Services\CartService;
use App\Contracts\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Contracts\OrderRepositoryInterface;
use App\Repositories\OrderRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
        
        User::observe(UserObserver::class);
        UserDetail::observe(UserDetailObserver::class);

        View::composer('frontend.includes.header', function ($view) {
            $cartCount = 0;
            $wishlistCount = 0;

            try {
                $cart = app(CartService::class)->getCart();
                if ($cart instanceof \App\Models\Cart) {
                    $cartCount = (int) ($cart->items?->sum('quantity') ?? 0);
                } else {
                    $cartCount = (int) collect($cart)->sum('quantity');
                }
            } catch (\Throwable $e) {
                $cartCount = 0;
            }

            if (Auth::check()) {
                $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
            }

            $view->with(compact('cartCount', 'wishlistCount'));
        });
    }
}
