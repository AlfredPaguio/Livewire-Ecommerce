<?php

namespace App\Livewire\Admin\Products;

use App\Models\Brands;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use App\Models\Products as ProductModel;

class Products extends Component
{
    use WithPagination;

    public $search;
    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';

    public function hide()
    {   
        if (session()->has('error')) {
            session()->forget('error');
        }

        if (session()->has('success')) {
            session()->forget('success');
        }
    }

    public function render()
    {
        $products = ProductModel::query();
        if($this->search) 
        {

            if (in_array(strtoupper($this->search), ['ACTIVE', 'INACTIVE'])) {
                $status = strtoupper($this->search) == 'ACTIVE' ? true : false;
            } else {
                $status = null;
            }
            
            if (in_array(strtoupper($this->search), ['YES', 'NO'])) {
                $featured = strtoupper($this->search) == 'YES' ? true : false;
            } else {
                $featured = null;
            }
           

            $products->where('name', 'like', "%{$this->search}%")
            ->orWhere('slug', 'like', "%{$this->search}%")
            ->orWhere('description', 'like', "%{$this->search}%")
            ->orwhereRelation('category', 'name', 'like', "%{$this->search}%")
            ->orwhereRelation('brand', 'name', 'like', "%{$this->search}%");

            if (!is_null($status)) {
                $products->orWhere('status', $status);
            }
            if (!is_null($featured)) {
                $products->orWhere('featured', $featured);
            }
        }
       
        return view('livewire.admin.products.products', [
            'products' => $products->latest()->paginate(5)
        ])->extends('layouts.admin');
    }
}
