<?php

namespace App\Providers;

use App\Product;
use App\ProductCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $brands  = ProductCategory::where('parent_id','<>',0)->get();
        $products = Product::all();
        $ProductCategorys = ProductCategory::all();
        $products_selling = Product::where('old_price','>','10000000')->limit(8)->get();
        View::share(['products' =>$products,'ProductCategorys'=> $ProductCategorys, 'products_selling' => $products_selling,'brands'=>$brands]);
    }
}
