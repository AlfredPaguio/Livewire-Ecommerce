<?php

namespace App\Http\Livewire\Admin\Settings\SettingsTab\SettingsTab2Modals;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CompanyProfile;

class SettingsTab2AddModal extends Component
{
    use WithFileUploads;
    
    public $company_profile;

    public $name;
    public $document;

    protected $rules = [
        'name' => 'required|string',
        'document' => 'required',
    ];

    public function mount()
    {
        $from_db = CompanyProfile::first();
         
        if ($from_db){
            $this->company_profile = $from_db;
            
        } else {
            $this->company_profile = new CompanyProfile();
        }
    }

    public function addCompanyDocuments()
    {
        $this->validate();

        $this->company_profile->documents()->create([
            'name' => $this->name,
            'filename' => $this->document->store('documents/uploads', 'public'),
        ]);

        $this->emit('sendSuccess', 'New document added.');
        $this->dispatchBrowserEvent('closeAddDocumentModal');
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->name = null;
        $this->document = null;
        $this->dispatchBrowserEvent('clearInputFile');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.admin.settings.settings-tab.settings-tab2-modals.settings-tab2-add-modal');
    }
}
