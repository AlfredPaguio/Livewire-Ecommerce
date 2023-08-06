<?php

namespace App\Livewire\Admin\Sliders;

use App\Models\Sliders as ModelsSliders;
use Livewire\Component;
use Livewire\WithPagination;

class Sliders extends Component
{
    use WithPagination;

    public $search;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search'];

    public function render()
    {
        $sliders = ModelsSliders::query();

        if($this->search) 
        {
            $sliders->where('title', 'like', "%{$this->search}%")
            ->orWhere('status', 'like', "%{$this->search}%")
            ->orWhere('description', 'like', "%{$this->search}%");
        }

        return view('livewire.admin.sliders.sliders',
        [
            'sliders' => $sliders->latest()->paginate(5)
        ]
        )->extends('layouts.admin');
    }


    public function hide()
    {   
        if (session()->has('danger')) {
            session()->forget('danger');
        }

        if (session()->has('success')) {
            session()->forget('success');
        }
    }
}
