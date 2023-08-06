<?php

namespace App\Livewire\Admin\Brands;

use App\Models\Brands;
use Livewire\Component;
use Illuminate\Support\Facades\File;


class BrandsDelete extends Component
{
    public $deleteBrand;

    public function deleteBrand($id)
    {
        $brand = Brands::find($id);

        if(File::exists(public_path('storage/'.$brand->image))){
            File::delete(public_path('storage/'.$brand->image));
        }
        
        $brand->delete();
        
        session()->flash('success', 'Brands has been deleted successfully!');


        return redirect()->route('admin.brands');
    }

    public function render()
    {
        return view('livewire.admin.brands.brands-delete');
    }
}
