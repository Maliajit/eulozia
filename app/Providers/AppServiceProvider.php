<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
                ->orderBy('sort_order', 'asc')
                ->take(5)
                ->get();
            $view->with('headerCategories', $headerCategories);
        });
    }
}
