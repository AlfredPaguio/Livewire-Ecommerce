<?php

namespace App\Livewire\Main\Cart;

use Livewire\Component;
use App\Models\Products;
use App\Models\Stocks;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class CartList extends Component
{

    public $cart_list;
    public $subtotal;
    public $tax;
    public $total;

    protected $listeners = [
        'addToCart',
    ];

    public function mount()
    {
        $cart = Auth::User()->shoppingCart();
        if ($cart and $cart->first() and $cart->first()->stocks){
            $this->cart_list = $cart->first()->stocks;
        }
       

    }

    public function removeFromCart($itemId)
    {
        auth()->user()->shoppingCart()->where('id', $itemId)->delete();

        $this->cart = $this->cart->filter(function ($item) use ($itemId) {
            return $item->id != $itemId;
        });

        $this->dispatch('cartUpdated');
    }

    public function clearCart()
    {
        auth()->user()->shoppingCart()->delete();

        $this->cartlist = collect([]);

        $this->dispatch('cartUpdated');
    }



    public function render()
    {
        return view('livewire.main.cart.cart-list');
    }
}
