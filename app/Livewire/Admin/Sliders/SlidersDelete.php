<?php

namespace App\Livewire\Admin\Sliders;

use App\Models\Sliders;
use Livewire\Component;
use Illuminate\Support\Facades\File;


class SlidersDelete extends Component
{
    public $deleteSlider;

    public function deleteSlider($id)
    {
        $slider = Sliders::find($id);

        if(File::exists(public_path('storage/'.$slider->image))){
            File::delete(public_path('storage/'.$slider->image));
        }
        
        $slider->delete();
        
        session()->flash('success', 'Slider has been deleted successfully!');

        return redirect()->route('admin.sliders');
    }

    public function render()
    {
        return view('livewire.admin.sliders.sliders-delete');
    }
}
