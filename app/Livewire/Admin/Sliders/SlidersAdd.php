<?php

namespace App\Livewire\Admin\Sliders;

use App\Models\Sliders;
use Livewire\Component;
use Livewire\WithFileUploads;

class SlidersAdd extends Component
{
    //TODO
    // 1. Add dimension validation to image
    // 2. Add image size validation to image

    use WithFileUploads;

    public $title;
    public $description;
    public $image;
    public $status = '1';

    protected $rules = [
        'title' => 'required|string',
        'description' => 'required|string',
        'image' => 'required|image|mimes:jpg,jpeg,png',
        'status' => 'required|string',
    ];

    public function createSlider()
    {
        $this->validate();
        $slider = new Sliders;
        
        $slider->title = $this->title;
        $slider->description = $this->description;
        $slider->status = $this->status;

        if($this->image){
            $filename = $this->image->store('images/uploads/sliders', 'public');
            $slider->image = $filename;
        }

        $slider->save();
        session()->flash('success', 'Slider has been created successfully!');
        return redirect()->route('admin.sliders');
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function render()
    {
        return view('livewire.admin.sliders.sliders-add')->extends('layouts.admin');
    }
}
