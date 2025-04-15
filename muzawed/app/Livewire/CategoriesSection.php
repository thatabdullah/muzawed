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
        $iconMap = [
            'Cloud computing' => 'cloud',
            'Data Science' => 'bar-chart-2',
            'Cyber Security' => 'shield',
            'Internet Of Things' => 'globe',
            'Artificial Intelligence' => 'cpu',
            'Enterprise Resource Planning (ERP)' => 'briefcase',
            'Development' => 'code',
            'BlockChain' => 'link',
            'Storage' => 'database',
            'Machine Learning' => 'activity',
            'Infrastructure' => 'server',
            'Cryptography' => 'lock',
            'Digital Transformation' => 'refresh-cw',
            'Communication' => 'message-square',
            'Fintech' => 'dollar-sign',
        ];

        return view('livewire.categories-section', [
            'iconMap' => $iconMap,
        ]);
    }
}
