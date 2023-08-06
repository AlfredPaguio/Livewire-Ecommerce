<?php

namespace App\Livewire\Admin\Brands;

use App\Models\Brands;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class BrandsAdd extends Component
{

    use WithFileUploads;

    public $name;
    public $slug;
    public $description;
    public $image;
    public $status = '1';
    public $category_id;

    public $categories;

    protected $rules = [
        'name' => 'required|string',
        'slug' => 'required|string',
        'description' => 'nullable|string',
        'image' => 'image|nullable|mimes:jpg,jpeg,png',
        'status' => 'required|string',
        'category_id' => 'required|numeric'
    ];

    public function createBrand()
    {
        $this->validate();
        $brand = new Brands;
        
        $brand->name = $this->name;
        $brand->slug = Str::slug($this->slug);
        $brand->description = $this->description;
        $brand->status = $this->status;
        $brand->category_id = $this->category_id;

        if($this->image){
            $filename = $this->image->store('images/uploads/brands', 'public');
            $brand->image = $filename;
        }

        $brand->save();
        session()->flash('success', 'Brand has been created successfully!');
        return redirect()->route('admin.brands');
    }

    public function mount()
    {
        $this->categories = Category::latest()->get();
    }

    public function updated($property)
    {
        if ($property == 'name'){
            is_null($this->name) ? reset($this->slug) : $this->slug = Str::slug($this->name);
        }
        $this->validateOnly($property);

        
    }


    public function render()
    {
        return view('livewire.admin.brands.brands-add')->extends('layouts.admin');
    }
}
