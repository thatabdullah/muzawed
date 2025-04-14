<?php

namespace App\Livewire;
use App\Models\Category;
use Livewire\Component;

class CategoriesSection extends Component
{
    public $categories;

    public function mount()
    {
        $this->categories = Category::all();
        \Log::info('Categories loaded', [
            'count' => $this->categories->count(),
            'categories' => $this->categories->pluck('name_en')->toArray(),
        ]);
    }
    
    public function render()
    {
        return view('livewire.categories-section');
    }
}
