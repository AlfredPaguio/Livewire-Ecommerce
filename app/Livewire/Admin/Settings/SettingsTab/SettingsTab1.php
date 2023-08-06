<?php

namespace App\Livewire\Admin\Settings\SettingsTab;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CompanyProfile;
use App\Models\CompanySocials;
use Illuminate\Support\Facades\File;

class SettingsTab1 extends Component
{
    use WithFileUploads;

    public CompanyProfile $company_profile;
    public $company_logo;
    public $socials = [];
    public $socials_copy = [];


    protected $rules = [
        'company_profile.name' => 'required|string',
        'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'socials.*.name' => 'required|string',
        'socials.*.link' => 'required|string',
    ];

    protected $messages = [
        'socials.*.name.required' => 'Social name is required.',
        'socials.*.name.string' => 'Social name must be a string.',
        'socials.*.link.required' => 'Social link is required.',
        'socials.*.link.string' => 'Social link must be a string.',
    ];

    public function mount()
    {
        $from_db = CompanyProfile::first();
        //$this->socials[] = new CompanySocials();
         
        if ($from_db){
            $this->company_profile = $from_db;  
        } else {
            $this->company_profile = new CompanyProfile();
        }

        //dd($this->company_profile->socials);
        foreach($this->company_profile->socials as $social)
        {
            $this->socials[] = $social;
        }

        $this->socials_copy = $this->socials;
    }

    public function addSocials()
    {
        $this->socials[] = new CompanySocials();
        session()->flash('success', 'New social form added.');
    }

    public function removeSocials($index)
    {
        if (isset($this->socials[$index])) {
            unset($this->socials[$index]);
        }
        
        session()->flash('success', 'Social form removed.');
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

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updateCompanyProfile()
    {
        $this->validate();

        if($this->company_logo){
            if(File::exists(public_path('storage/'.$this->company_profile->logo))){
                File::delete(public_path('storage/'.$this->company_profile->logo));
            }

            $filename = $this->company_logo->store('images/uploads/company', 'public');
            $this->company_profile->logo = $filename;
        }

        $this->company_profile->save();

        $social_difference = array_udiff($this->socials_copy, $this->socials, function ($a, $b) {
            return strcmp(serialize($a), serialize($b));
        });

        //dd($social_difference);
        if($social_difference)
        {
            foreach($social_difference as $deleted_item)
            {
                if(array_key_exists('id', $deleted_item))
                {
                    // Delete deleted form from socials array
                    $this->company_profile->socials->find($deleted_item['id'])->delete();
                } 
            }
        }

        foreach($this->socials as $social)
        {   
            
            $this->company_profile->socials()->updateOrCreate(
                [
                    'name' => $social['name'],
                    'link' => $social['link'],
                ]
            );
        }

       
        session()->flash('success', 'Company profile updated successfully.');
        return redirect()->route('admin.settings');
    }

    public function render()
    {
        return view('livewire.admin.settings.settings-tab.settings-tab1');
    }
}
