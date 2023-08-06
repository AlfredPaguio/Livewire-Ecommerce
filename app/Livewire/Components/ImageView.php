<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ImageView extends Component
{

    public $image, $alt, $className, $style, $width, $height, $src, $loading, $isProfile = false;

    public function mount()
    {
        if (!$this->className) {
            $this->className = 'image-fluid fixed-size-sm';
        }

        if (!$this->loading){
            $this->loading = 'lazy';
        }

        
        if ($this->image) {
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                $this->src = $this->image;
            } elseif ($this->image) {
                $this->src = asset('storage/' . $this->image);
            } else {
                $this->src = asset('images/no-photo.svg');
            }
        } else {
            $this->src = asset('images/no-photo.svg');
        }
    }

    public function render()
    {
        return view('livewire.components.image-view');
    }
}
