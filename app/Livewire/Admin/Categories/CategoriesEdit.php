<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;

class CategoriesEdit extends Component
{

    use WithFileUploads;
    
    public $category;

    public $name_title;
    public $name_edit;
    public $slug_edit;
    public $description_edit;
    public $image_edit;
    public $status_edit;
    public $meta_name_edit;
    public $meta_keyword_edit;
    public $meta_description_edit;

    public function mount($id)
    {
        $this->category = Category::find($id);
        $this->name_title = $this->category->name;

        $this->name_edit = $this->category->name;
        $this->slug_edit = $this->category->slug;
        $this->description_edit = $this->category->description;
        //  $this->image_edit = $this->category->image;
        $this->status_edit = $this->category->status;
        $this->meta_name_edit = $this->category->meta_name;
        $this->meta_keyword_edit = $this->category->meta_keyword;
        $this->meta_description_edit = $this->category->meta_description;

    }

    protected $rules = [
        'name_edit' => 'required|string',
        'slug_edit' => 'required|string',
        'description_edit' => 'nullable|string',
        'image_edit' => 'image|nullable|mimes:jpg,jpeg,png',
        'status_edit' => 'required|string',
        'meta_name_edit' => 'required|string',
        'meta_keyword_edit' => 'required|string',
        'meta_description_edit' => 'nullable|string',
    ];
      
    public function editCategory() 
    {
        $this->validate();

        if($this->image_edit){
            if(File::exists(public_path('storage/'.$this->category->image))){
                File::delete(public_path('storage/'.$this->category->image));
            }
            $filename = $this->image_edit->store('images/uploads/categories', 'public');
            $this->category->image = $filename;
        }
        
        $this->category->update(
            [
                'name' => $this->name_edit,
                'slug' => Str::slug($this->slug_edit),
                'description' => $this->description_edit,
                'status' => $this->status_edit,
                'meta_name' => $this->meta_name_edit,
                'meta_keyword' => $this->meta_keyword_edit,
                'meta_description' => $this->meta_description_edit,
            ]
        );
        
        session()->flash('success', 'Category updated successfully.');
        return redirect()->route('admin.categories');
    }
 
    public function render()
    {
        return view('livewire.admin.categories.categories-edit')->extends('layouts.admin');
    }

    public function updated($property)
    {
        if ($property == 'name'){
            is_null($this->name) ? reset($this->slug) : $this->slug = Str::slug($this->name);
        }
        $this->validateOnly($property);
    }
}
