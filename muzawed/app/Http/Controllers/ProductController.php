<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function __invoke($locale)
    {
        
        app()->setLocale($locale);

        $cacheKey = "products.page.{$locale}";

        $products = Cache::remember($cacheKey, 60, function () {
            return Product::with(['category', 'tags'])
                ->where('active', true)
                ->get();
        });

        return view('products', ['products' => $products]);
    }
}