<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;

class Settings extends Component
{
    public $tab = 'company_profile';
    
    public function render()
    {
        return view('livewire.admin.settings.settings')->extends('layouts.admin');
    }
}
