<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use App\Models\Products;
use App\Models\ProductImages;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductsDelete extends Component
{
    public $deleteProduct;

    public function delete($id)
    {
       
        $product = Products::find($id);

        if ($product->images) {
            
            // Delete the directory itself
            File::deleteDirectory(public_path('storage/images/uploads/products/'.$product->id));
        }
        
        //dd('not called');
        $product->delete();
        
        session()->flash('success', 'Product has been deleted successfully!');

        return redirect()->route('admin.products');
    }
    
    public function render()
    {
        return view('livewire.admin.products.products-delete');
    }
}
