<?php

namespace App\Livewire\Admin\Settings\SettingsTab;

use App\Models\CompanyDocuments;
use Livewire\Component;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\File;

class SettingsTab2 extends Component
{
    
    public $company_profile;

    protected $listeners = ['sendSuccess'];

    public function mount()
    {
        $from_db = CompanyProfile::first();
         
        if ($from_db){
            $this->company_profile = $from_db;
            
        } else {
            $this->company_profile = new CompanyProfile();
        }
    }

    public function downloadFile($id)
    {
        $file = CompanyDocuments::find($id);

        $filepath = public_path('storage/'.$file->filename);
        $url = asset($file->filename);

        if (!File::exists($filepath)) {
            session()->flash('error', 'File not found.');
            return redirect()->back();
        }

        $modified_filename = $file->name.'.'.pathinfo($file->filename, PATHINFO_EXTENSION);
       
        session()->flash('success', 'File downloaded successfully.');
        return response()->download($filepath, $modified_filename);
    }

    public function hide()
    {   
        if (session()->has('error')) {
            session()->forget('error');
        }

        if (session()->has('success')) {
            session()->forget('success');
        }
    }

    public function sendSuccess($message)
    {
        session()->flash('success', $message);
    }


    public function render()
    {
        return view('livewire.admin.settings.settings-tab.settings-tab2');
    }
}
