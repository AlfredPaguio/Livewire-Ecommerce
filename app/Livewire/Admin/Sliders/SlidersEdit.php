<?php

namespace App\Livewire\Admin\Sliders;

use App\Models\Sliders;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;

class SlidersEdit extends Component
{
    use WithFileUploads;
    
    public $slider;

    public $title;
    public $description;
    public $image;
    public $status;

    protected $rules = [
        'title' => 'required|string',
        'description' => 'required|string',
        'image' => 'image|nullable|mimes:jpg,jpeg,png',
        'status' => 'required|string',
    ]; 

    public function mount($id)
    {
        $this->slider = Sliders::find($id);

        $this->title = $this->slider->title;
        $this->description = $this->slider->description;
        $this->status= $this->slider->status;
       
    }

    public function editSlider() 
    {
        $this->validate();

        if($this->image){
            if(File::exists(public_path('storage/'.$this->slider->image))){
                File::delete(public_path('storage/'.$this->slider->image));
            }

            $filename = $this->image->store('images/uploads/sliders', 'public');
            $this->slider->image = $filename;
        }
        
        $this->slider->update(
            [
                'title' => $this->title,
                'description' => $this->description,
                'status' => $this->status,     
            ]
        );
        
        session()->flash('success', 'Slider updated successfully.');
        return redirect()->route('admin.sliders');
    }
 
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function render()
    {
        return view('livewire.admin.sliders.sliders-edit')->extends('layouts.admin');
    }
}
