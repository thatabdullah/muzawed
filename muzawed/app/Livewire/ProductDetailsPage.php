<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductDetailsPage extends Component
{
    public $product;

    public function mount($id)
    {
        $this->product = Product::where('active', true)
            ->with(['category', 'account', 'tags'])
            ->findOrFail($id);

        \Log::info('ProductPage mounted', [
            'product_id' => $id,
            'product_name' => $this->product->name,
            'tags' => $this->product->tags->pluck('id')->toArray(),
        ]);
    }
    public function render()
    {
        return view('livewire.product-details-page');
    }
}
