<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class Categories extends Component
{

    use WithPagination;
    public $search;
    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';

    public function hide()
    {   
        if (session()->has('danger')) {
            session()->forget('danger');
        }

        if (session()->has('success')) {
            session()->forget('success');
        }
    }

    public function render()
    {
        $categories = Category::query();

        if($this->search) 
        {
            if (in_array(strtoupper($this->search), ['ACTIVE', 'INACTIVE'])) {
                $status = strtoupper($this->search) == 'ACTIVE' ? true : false;
            } else {
                $status = null;
            }

            $categories->where('name', 'like', "%{$this->search}%")
            ->orWhere('slug', 'like', "%{$this->search}%")
            ->orWhere('description', 'like', "%{$this->search}%");
            
            
            if (!is_null($status)) {
                $categories->orWhere('status', $status);
            }
        }

        return view('livewire.admin.categories.categories', [
            'categories' => $categories->latest()->paginate(5)
        ])->extends('layouts.admin');
    }

    public function updated($property)
    {
        if ($property == 'search')
        {
            $this->resetPage();
        }
    }
}
