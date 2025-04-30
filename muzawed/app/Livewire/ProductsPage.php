<?php
namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag; 
use Livewire\Component;

class ProductsPage extends Component
{
    public $search = '';
    public $category_id = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $selectedTag = '';
    public $categories;
    public $product;

    public function mount()
    {
        $this->category_id = request()->query('category_id', '');
        $this->categories = Category::all();
        $this->product = Product::first();
        
    }

    public function updated($property)
    {

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
            \Log::info('Tag Filter Applied', ['selectedTag' => $this->selectedTag]);
            $query->whereHas('tags', function ($q) {
                $q->where('tags.id', $this->selectedTag);
            });
        }

        if ($this->sortBy === 'name') {
            $query->orderBy('name', $this->sortDirection);
        } else {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        $products = $query->get();
        $categories = Category::all();
        $tags = Tag::all(); 

        return view('livewire.products-page', [
            'products' => $products,
            'categories' => $categories,
            'categories' => $this->categories,
            'tags' => Tag::all(), 
        ]);
    }
}