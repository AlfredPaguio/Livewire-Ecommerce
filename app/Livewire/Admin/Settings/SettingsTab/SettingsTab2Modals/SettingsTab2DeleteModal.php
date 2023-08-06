<?php

namespace App\Livewire\Admin\Settings\SettingsTab\SettingsTab2Modals;

use Livewire\Component;
use App\Models\CompanyDocuments;
use Illuminate\Support\Facades\File;

class SettingsTab2DeleteModal extends Component
{
    public $deleteDocument;

    public function deleteDocument($id)
    {
        $document = CompanyDocuments::find($id);

        if(File::exists(public_path('storage/'.$document->filename)))
        {
            File::delete(public_path('storage/'.$document->filename));
        }

        $document->delete();

        $this->dispatch('sendSuccess', 'Document deleted successfully.');
        $this->dispatch('closeDeleteDocumentModal', ['id' => $id]);
    }

    public function render()
    {
        return view('livewire.admin.settings.settings-tab.settings-tab2-modals.settings-tab2-delete-modal');
    }
}
