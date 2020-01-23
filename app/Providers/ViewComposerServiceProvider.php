<?php

namespace App\Providers;

use Cart;
use App\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('front.partials.nav', function ($view) {
            $view->with('categories', Category::orderBy('name', 'asc')->get()->toTree());
        });
        View::composer('front.partials.header', function ($view) {
            $view->with('cartCount', Cart::getContent()->count());
        });
    }
}
