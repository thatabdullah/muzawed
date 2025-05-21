<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class ProductsPage extends Component
{
    public $search = '';
    public $category_id = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $selectedTag = '';
    public $product;

    public function mount()
    {
        $this->category_id = request()->query('category_id', '');

        // Cache the first product if needed
        $this->product = Cache::remember('first_product', 600, function () {
            return Product::first();
        });
    }

    public function updated($property)
    {
        // Handle property updates if needed
    }

    public function sort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = $field === 'average_rating' ? 'desc' : 'asc';
        }
    }

    public function render()
    {
        // Generate a safe cache key
        $cacheKey = 'products_' . md5($this->search . '_' . $this->category_id . '_' . $this->selectedTag . '_' . app()->getLocale());

        try {
            // Cache products for 10 minutes
            $products = Cache::remember($cacheKey, 600, function () {
                $query = Product::where('active', true)
                    ->with(['category', 'account', 'tags', 'reviews']);

                if ($this->search) {
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('description_en', 'like', '%' . $this->search . '%')
                          ->orWhere('description_ar', 'like', '%' . $this->search . '%')
                          ->orWhereHas('account', function ($q) {
                              $q->where('name', 'like', '%' . $this->search . '%');
                          });
                    });
                }

                if ($this->category_id) {
                    $query->where('category_id', $this->category_id);
                }

                if ($this->selectedTag) {
                    $query->whereHas('tags', function ($q) {
                        $q->where('tags.id', $this->selectedTag);
                    });
                }

                $allowedSorts = ['name', 'average_rating'];
                $sortBy = in_array($this->sortBy, $allowedSorts) ? $this->sortBy : 'name';
                $sortDirection = in_array($this->sortDirection, ['asc', 'desc']) ? $this->sortDirection : 'asc';
                $query->orderBy($sortBy, $sortDirection);

                return $query->get();
            });

            // Cache categories for 1 day
            $categories = Cache::remember('categories_all', 86400, function () {
                return Category::all();
            });

            // Cache tags for 1 day
            $tags = Cache::remember('tags_all', 86400, function () {
                return Tag::all();
            });
        } catch (\Exception $e) {
            $products = collect([]);
            $categories = collect([]);
            $tags = collect([]);
        }

        return view('livewire.products-page', [
            'products' => $products,
            'categories' => $categories,
            'tags' => $tags,
            'product' => $this->product,
        ]);
    }
}