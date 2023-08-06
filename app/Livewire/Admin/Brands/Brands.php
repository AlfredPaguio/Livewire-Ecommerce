<?php

namespace App\Livewire\Admin\Brands;

use App\Models\Brands as ModelsBrands;
use Livewire\Component;
use Livewire\WithPagination;



class Brands extends Component
{
    use WithPagination;

    public $search;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search'];


    public function render()
    {
        $brands = ModelsBrands::query();
        

        if($this->search) 
        {
            if (in_array(strtoupper($this->search), ['ACTIVE', 'INACTIVE'])) {
                $status = strtoupper($this->search) == 'ACTIVE' ? true : false;
            } else {
                $status = null;
            }
          
            
            $brands->where('name', 'like', "%{$this->search}%")
            ->orWhere('slug', 'like', "%{$this->search}%")
            ->orWhere('description', 'like', "%{$this->search}%");

            if (!is_null($status)) {
                $brands->orWhere('status', $status);
            }

        }

        return view('livewire.admin.brands.brands',
        [
            'brands' => $brands->latest()->paginate(5)
        ]
        )->extends('layouts.admin');
    }

    public function updated($property)
    {
        if ($property == 'search')
        {
            $this->resetPage();

        }
    }

    public function hide()
    {   
        if (session()->has('danger')) {
            session()->forget('danger');
        }

        if (session()->has('success')) {
            session()->forget('success');
        }
    }

}
