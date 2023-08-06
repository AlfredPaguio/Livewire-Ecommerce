<?php

namespace App\Livewire\Main\Products;

use Livewire\Component;
use App\Models\Products;

class Product extends Component
{

    public $quantity = 1;

    public Products $product;
    public $stocks =[];

    public function mount($id)
    {
        $this->product = Products::find($id);

        foreach ($this->product->stocks as $stock) {
            $this->stocks[] = $stock;
        }
    }

    public function decrement()
    {
        if ($this->quantity > 0) {
            $this->quantity--;
        }
    }

    public function increment()
    {
        $this->quantity++;
    }

    public function render()
    {
        return view('livewire.main.products.product');
    }
}
