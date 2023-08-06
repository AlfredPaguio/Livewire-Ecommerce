<?php

namespace App\Livewire\Main\Wishlist;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Wishlist extends Component
{

    public $wishlist;


    public function mount()
    {
        $this->wishlist = Auth::User()->wishlist;
    
    }

    public function addAllToCart()
    {
        foreach ($this->wishlist as $item) {
            // Verify if the item is truly on the database
            $db = Wishlist::find($item->id);
            if ($db){
                $this->dispatch('addToCart', $item->id);
            }
        }
    }

    public function addToCart($itemId)
    {
        // Verify if the item is truly on the database
        $item = Wishlist::find($itemId);
        if ($item){
            $this->dispatch('addToCart', $itemId);
        }
    }


    public function render()
    {
        return view('livewire.main.wishlist.wishlist');
    }
}
