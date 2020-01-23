<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\CategoryContract;
use App\Repositories\CategoryRepository;
use App\Contracts\ProductContract;
use App\Repositories\ProductRepository;
use App\Contracts\AttributeContract;
use App\Repositories\AttributeRepository;
use App\Contracts\OrderContract;
use App\Repositories\OrderRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        CategoryContract::class  =>  CategoryRepository::class,
        ProductContract::class  =>  ProductRepository::class,
        AttributeContract::class => AttributeRepository::class,
        OrderContract::class => OrderRepository::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation)
        {
            $this->app->bind($interface, $implementation);
        }
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
