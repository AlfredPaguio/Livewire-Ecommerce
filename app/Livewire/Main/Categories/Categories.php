<?php

namespace App\Livewire\Main\Categories;

use Livewire\Component;
use App\Models\Category;

class Categories extends Component
{
    public $search;
    
    public function render()
    {
        $categories = Category::query();

        if($this->search) 
        {
            $categories->where('name', 'like', "%{$this->search}%")
            ->orWhere('slug', 'like', "%{$this->search}%")
            ->orWhere('description', 'like', "%{$this->search}%")
            ->orWhere('status', 'like', "%{$this->search}%");;
        }

        return view('livewire.main.categories.categories', [
            'categories' => $categories->latest()->take(10)->get()
        ]);
    }
}
