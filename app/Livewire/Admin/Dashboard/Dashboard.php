<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;

class Dashboard extends Component
{
    public function hide()
    {
        session()->forget('success');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.dashboard')->extends('layouts.admin');
    }
}
