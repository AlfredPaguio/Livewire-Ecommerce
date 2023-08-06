<?php

namespace App\Livewire\Admin\Settings\SettingsTab\SettingsTab2Modals;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CompanyDocuments;
use Illuminate\Support\Facades\File;

class SettingsTab2EditModal extends Component
{
    use WithFileUploads;

    public $editDocument;
    public $name;
    public $document;

    public $company_documents;

    protected $rules = [
        'name' => 'required|string',
        'document' => 'nullable|mimes:pdf,doc,docx,xml',
    ];

    public function mount()
    {
        $this->company_documents = CompanyDocuments::find($this->editDocument->id);
        $this->name = $this->company_documents->name;
        
        //$this->document = pathinfo($this->company_documents->filename, PATHINFO_BASENAME);
        
    }
    
    public function editCompanyDocuments()
    {
        $this->validate();

        $this->company_documents->name = $this->name;

        if($this->document)
        {   
            // Delete old file
            if(File::exists(public_path('storage/'.$this->company_documents->filename)))
            {
                File::delete(public_path('storage/'.$this->company_documents->filename));
            } 

            $this->company_documents->filename = $this->document->store('documents/uploads', 'public');
        }

        $this->company_documents->save();

        $this->dispatch('sendSuccess', 'Document updated successfully.');
        $this->dispatch('closeEditDocumentModal', ['id' => $this->editDocument->id]);
    }

    public function render()
    {
        return view('livewire.admin.settings.settings-tab.settings-tab2-modals.settings-tab2-edit-modal');
    }
}
