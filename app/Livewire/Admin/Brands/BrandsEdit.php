<?php

namespace App\Livewire\Admin\Brands;

use App\Models\Brands;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;

class BrandsEdit extends Component
{
    use WithFileUploads;
    
    public $brand;

    public $name;
    public $slug;
    public $image;
    public $status;
    public $category_id;

    public $categories;


    protected $rules = [
        'name' => 'required|string',
        'slug' => 'required|string',
        'image' => 'image|nullable|mimes:jpg,jpeg,png',
        'status' => 'required|string',
    ]; 

    public function mount($id)
    {
        $this->brand = Brands::find($id);
        $this->name = $this->brand->name;
        $this->slug = $this->brand->slug;
        $this->status= $this->brand->status;

        $this->categories = Category::latest()->get();
       
    }

    public function editBrand() 
    {
        $this->validate();

        if($this->image){
            if(File::exists(public_path('storage/'.$this->brand->image))){
                File::delete(public_path('storage/'.$this->brand->image));
            }
            $filename = $this->image->store('images/uploads/brands', 'public');
            $this->brand->image = $filename;
        }
        
        $this->brand->update(
            [
                'name' => $this->name,
                'slug' => Str::slug($this->slug),
                'status' => $this->status,
                'category_id' => $this->category_id,
                
            ]
        );
        
        session()->flash('success', 'Brand updated successfully.');
        return redirect()->route('admin.brands');
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
        return view('livewire.admin.brands.brands-edit')->extends('layouts.admin');;
    }
}
