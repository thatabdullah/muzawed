<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
class FeaturedProducts extends Component
{
    public $products;
    public function mount()
    {
        $this->products = Product::where('featured', true)
            ->with('account', 'tags')
            ->take(4)
            ->get()
            ->map(function ($product) {
                $product->logo = $logos[$product->name] ?? 'https://via.placeholder.com/64x32?text=' . urlencode($product->name);
                return $product;
            });
    }
    public function render()
    {
        return view('livewire.featured-products');
    }
}
