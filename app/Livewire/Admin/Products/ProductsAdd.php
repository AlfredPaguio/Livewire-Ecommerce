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

class ProductsAdd extends Component
{
    use WithFileUploads;

    public $tab = 'products';
    public $stocks = [];
    public $images = [];

    // Selections
    public $categories = [];
    public $brands = [];

    // Product Info
    public $name;
    public $slug;
    public $description;
    public $category;
    public $brand;
    public $status = '1';
    public $featured = '0';
    public $meta_name;
    public $meta_keyword;
    public $meta_description;

    protected $rules = [
        // * Product
        'name' => 'required|string',
        'slug' => 'required|string',
        'description' => 'nullable|string',
        'category' => 'required|string',
        'brand' => 'required|string|not_in:-1',
        'status' => 'required|string',
        'featured' => 'required|string',
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
        'images' => 'required|array',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ];

    protected $messages = [
        'stocks.*.name.required' => 'The name field is required for all stocks.',
        'stocks.*.quantity.required' => 'The quantity field is required for all stocks.',
        'stocks.*.status.required' => 'The status field is required for all stocks.',
        'stocks.*.original_price.required' => 'The original price field is required for all stocks.',
        'stocks.*.selling_price.required' => 'The selling price field is required for all stocks.',

        'stocks.*.name.string' => 'The name field must be a string for all stocks.',
        'stocks.*.status.string' => 'The status field must be a string for all stocks.',
        'stocks.*.quantity.numeric' => 'The quantity field must be numeric for all stocks.',
        'stocks.*.original_price.numeric' => 'The original price field must be numeric for all stocks.',
        'stocks.*.selling_price.numeric' => 'The selling price field must be numeric for all stocks.',
    ];

    public function createProduct()
    {
        $this->validate();

        // * Product
        $product = new Products();
        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->category_id = $this->category;
        $product->brand_id = $this->brand;
        $product->description = $this->description;
        $product->status = $this->status;
        $product->featured = $this->featured;
        $product->meta_name = $this->meta_name;
        $product->meta_keyword = $this->meta_keyword;
        $product->meta_description = $this->meta_description;
        
        $product->save();

        // * Stocks
        foreach ($this->stocks as $stock) {

            $newStock = new Stocks();
            $newStock->name = $stock['name'];
            $newStock->quantity = $stock['quantity'];
            $newStock->original_price = $stock['original_price'];
            $newStock->selling_price = $stock['selling_price'];
            $newStock->status = $stock['status'];

            $product->stocks()->save($newStock);
        }

        // * Images
        foreach ($this->images as $image) {
            $filename = $image->store('images/uploads/products/'.$product->id, 'public');
            
            $productImage = new ProductImages([
                'filename' => $filename
            ]);
            
            $product->images()->save($productImage);
        }

        session()->flash('success', 'Product added successfully.');
        return redirect()->route('admin.products');
    }

    public function mount()
    {
        $this->categories = Category::latest()->get();
        $this->stocks[] = new Stocks();  
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
        return view('livewire.admin.products.products-add')->extends('layouts.admin');
    }
}