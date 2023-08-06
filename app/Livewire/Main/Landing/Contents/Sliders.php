<?php

namespace App\Livewire\Main\Landing\Contents;

use App\Models\Sliders as SliderModel;
use Livewire\Component;

class Sliders extends Component
{
    public $sliders;

    public function mount()
    {
        $this->sliders = SliderModel::latest()->get();
    }

    public function render()
    {
        return view('livewire.main.landing.contents.sliders');
    }
}
