<?php

namespace App\Livewire\Admin\Products;

use App\Models\Brands;
use App\Models\Stocks;
use Livewire\Component;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Support\Str;
use App\Models\ProductImages;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductsEdit extends Component
{
    use WithFileUploads;
    public $tab = 'products';

    public $product;
    public $stocks = [];
    public $stocks_copy = [];
    public $images = [];
    public $images_edit = [];
    public $images_copy = [];

    // Selections
    public $categories;
    public $brands;

    // Product Info
    public $name;
    public $slug;
    public $description;
    public $category;
    public $brand;
    public $status;
    public $featured;
    public $meta_name;
    public $meta_keyword;
    public $meta_description;

    protected $rules = [
        // * Product
        'name' => 'required|string',
        'slug' => 'required|string',
        'description' => 'nullable|string',
        'category' => 'required|not_in:-1',
        'brand' => 'required|not_in:-1',
        'status' => 'required',
        'featured' => 'required',
        'meta_name' => 'required|string',
        'meta_keyword' => 'required|string',
        'meta_description' => 'nullable|string',

        // * Stocks
        'stocks.*.name' => 'required|string',
        'stocks.*.quantity' => 'required|numeric',
        'stocks.*.status' => 'required|string',
        'stocks.*.original_price' => 'required|numeric',
        'stocks.*.selling_price' => 'required|numeric',

        // * Images
        'images_edit.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];

    protected $messages = [
        'stocks.*.name.required' => 'The name field is required for all stocks.',
        'stocks.*.quantity.required' => 'The quantity field is required for all stocks.',
        'stocks.*.status.required' => 'The status field is required for all stocks.',
        'stocks.*.original_price.required' => 'The original price field is required for all stocks.',
        'stocks.*.selling_price.required' => 'The selling price field is required for all stocks.',

        'stocks.*.name.string' => 'The name field must be a string for all stocks.',
        'stocks.*.status.string' => 'The status field must be a string for all stocks.',
        'stocks.*.quantity.numeric' => '{{ The  }}quantity field must be numeric for all stocks.',
        'stocks.*.original_price.numeric' => 'The original price field must be numeric for all stocks.',
        'stocks.*.selling_price.numeric' => 'The selling price field must be numeric for all stocks.',
    ];

    public function mount($id)
    {
        $this->categories = Category::all();
        
        
        // Get Product
        $this->product = Products::find($id);

        $this->name = $this->product->name;
        $this->slug = $this->product->slug;
        $this->description = $this->product->description;
        $this->status = $this->product->status;
        $this->featured = $this->product->featured;
        $this->meta_name = $this->product->meta_name;
        $this->meta_keyword = $this->product->meta_keyword;
        $this->meta_description = $this->product->meta_description;
        $this->brand = $this->product->brand->id;
        $this->category = $this->product->category->id;

        $this->brands = Brands::where('category_id', $this->product->category->id)->get();

        // Get Stocks
        foreach ($this->product->stocks as $stock) {
            $this->stocks[] = $stock;
        }

        // Get copy of stock for existing stocks
        $this->stocks_copy = $this->stocks;

        // Get Images
        foreach($this->product->images as $image)
        {
            $this->images[] = $image;
        }

        // Get copy of images for existing images
        $this->images_copy = $this->images;
    }

    public function editProduct()
    {
        $this->validate();

        // Update Product       
        $this->product->name = $this->name;
        $this->product->slug = $this->slug;
        $this->product->category_id = $this->category;
        $this->product->brand_id = $this->brand;
        $this->product->description = $this->description;
        $this->product->status = $this->status;
        $this->product->featured = $this->featured;
        $this->product->meta_name = $this->meta_name;
        $this->product->meta_keyword = $this->meta_keyword;
        $this->product->meta_description = $this->meta_description;
        
        $this->product->update();
        // Update Stocks

        // Get the difference between $stocks and $stocks_copy
        $differences = array_udiff($this->stocks_copy, $this->stocks, function ($a, $b) {
            return strcmp(serialize($a), serialize($b));
        });
        
        // Delete deleted forms from stocks first. 
        if($differences)
        {
            foreach($differences as $difference)
            {
                if(array_key_exists('id', $difference))
                {
                    // Delete deleted form from stock array
                    $this->product->stocks()->find($difference['id'])->delete();
                } 
            }
        }

        // Update/Create remaining forms
        foreach($this->stocks as $stock)
        {   
            
            $this->product->stocks()->updateOrCreate(
                [
                    'name' => $stock['name'],
                    'quantity' => $stock['quantity'],
                    'original_price' => $stock['original_price'],
                    'selling_price' => $stock['selling_price'],
                    'status' => $stock['status'],
                ]
            );
        }
        
        
        // Update Images

        // Get the difference between $images and $images_copy
        $imageDifferences = array_udiff($this->images_copy, $this->images, function ($a, $b) {
            return strcmp(serialize($a), serialize($b));
        });

        // Delete images that differ from images and images_copy array
        if ($imageDifferences){
            foreach($imageDifferences as $diff)
            {
                if(array_key_exists('id', $diff))
                {
                    $this->product->images()->find($diff['id'])->delete();

                    if(File::exists(public_path('storage/'.$diff['filename'])))
                    {
                        File::delete(public_path('storage/'.$diff['filename']));
                    }
                }
            }
        }
 
        // Save new images from images_edit array
        foreach ($this->images_edit as $image) {
            
            $filename = $image->store('images/uploads/products/'.$this->product->id, 'public');
            
            $this->product->images()->create([
                'filename' => $filename,
            ]);
        }

        session()->flash('success', 'Product edited successfully.');
        return redirect()->route('admin.products');
    }

    public function addStock()
    {
        $this->stocks[] = new Stocks();

        session()->flash('success', 'Stock form added successfully.');
    }

    public function removeStock($index)
    {
        if (isset($this->stocks[$index])) {
            unset($this->stocks[$index]);
        }

        session()->flash('success', 'Stock form removed successfully.');
    }

    public function removeImage($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
        }

        session()->flash('success', 'Image removed successfully.');
    }

    public function removeImageEdit($index)
    {
        if (isset($this->images_edit[$index])) {
            unset($this->images_edit[$index]);
        }

        session()->flash('success', 'Image removed successfully.');
    }

    public function matchBrands()
    {
        $this->brands = Brands::where('category_id', $this->category)->latest()->get();
        $this->brand = -1;    
    }

    public function updated($property)
    {
        if ($property == 'name'){
            is_null($this->name) ? reset($this->slug) : $this->slug = Str::slug($this->name);
        }
        $this->validateOnly($property);   
    }

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
        return view('livewire.admin.products.products-edit')->extends('layouts.admin');
    }
}
