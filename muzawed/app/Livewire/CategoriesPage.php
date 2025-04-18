<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoriesPage extends Component
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
        return view('livewire.categories-page');
    }
}
