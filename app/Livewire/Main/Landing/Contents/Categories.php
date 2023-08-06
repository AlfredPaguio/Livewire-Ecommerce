<?php

namespace App\Livewire\Main\Landing\Contents;

use Livewire\Component;
use App\Models\Category;

class Categories extends Component
{
    public $categories;

    public function mount()
    {
        $this->categories = Category::where('status', 1)->latest()->take(10)->get();
    }


    public function render()
    {
        return view('livewire.main.landing.contents.categories');
    }
}
