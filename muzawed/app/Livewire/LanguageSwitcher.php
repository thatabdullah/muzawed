<?php
namespace App\Livewire;

use Livewire\Component;

class LanguageSwitcher extends Component
{
    public $currentLocale;

    public function mount()
    {
        $this->currentLocale = app()->getLocale();
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
