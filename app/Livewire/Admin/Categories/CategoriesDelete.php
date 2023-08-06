<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\File;


class CategoriesDelete extends Component
{
    public $deleteCategory;

    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if(File::exists(public_path('storage/'.$category->image))){
            File::delete(public_path('storage/'.$category->image));
        }
        
        $category->delete();
        
        session()->flash('success', 'Category has been deleted successfully!');

        return redirect()->route('admin.categories');
    }

    public function render()
    {
        return view('livewire.admin.categories.categories-delete');
    }
}
