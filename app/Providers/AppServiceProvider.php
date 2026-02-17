<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Helpers\CartHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('customer.partials.header', function ($view) {
            $headerCategories = Category::where('status', 1)
                ->where('show_in_nav', 1)
                ->orderBy('sort_order', 'asc')
                ->take(5)
                ->get();

            $cartHelper = app(CartHelper::class);
            $cartCount = $cartHelper->getCartCount();

            $view->with([
                'headerCategories' => $headerCategories,
                'cartCount' => $cartCount
            ]);
        });
    }
}
