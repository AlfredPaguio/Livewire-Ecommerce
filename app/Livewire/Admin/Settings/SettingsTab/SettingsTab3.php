<?php

namespace App\Livewire\Admin\Settings\SettingsTab;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class SettingsTab3 extends Component
{
    use WithFileUploads;
    public $user;
    public $image;

    //passwords
    public $current_password;
    public $new_password;
    public $confirm_password;

    protected $rules = [
        'current_password' => 'required',
        'new_password' => ['required', 'string', 'min:8', 
        'regex:/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/'],
        'confirm_password' => ['required', 'same:new_password'],
    ];

    protected $messages = [
        'password.regex' => 'Password must be at least 8 characters and 
        contain at least one number and one special character.',
        'confirm_password.regex' => 'Confirm password must be at least 8 characters and
        contain at least one number and one special character.'
    ];

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function uploadImage()
    {
        $this->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB Max
        ]);

        if ($this->image){
            if(File::exists(public_path('storage/'.$this->user->image))){
                File::delete(public_path('storage/'.$this->user->image));
            }

            $filename = $this->image->store('images/users/'.$this->user->id.'/uploads', 'public');
            $this->user->image = $filename;
            $this->user->save();
            session()->flash('success', 'Image updated successfully.');
        } else {
            $this->addError('image', 'Image is not valid');
        }

    }

    public function removeImage()
    {
        if(File::exists(public_path('storage/'.$this->user->image))){
            File::delete(public_path('storage/'.$this->user->image));
        }
        $this->reset('image');

        $this->user->image = null;
        $this->user->save();
        session()->flash('success', 'Image remove successfully.');
    }

    public function changePassword()
    {
        $this->validate($this->rules, $this->messages);

        
        // Check if the old password is correct
        if (Hash::check($this->current_password, $this->user->password)) {

            if(Hash::check($this->new_password, $this->user->password)) {
                session()->flash('danger', 'New password cannot be the same as the old password.');
                return;
            }

            //Update the user's password

            $this->user->password = Hash::make($this->new_password);
            $this->user->save();

            Auth::logout();
            session()->flash('success', 'Password updated successfully. Please login again.');
            
            return redirect()->route('login');
            //Logout the user
        } else {
            session()->flash('danger', 'Passwords do not match.');
        }
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

    public function updated($property)
    {
        $this->validateOnly($property, [
            'image' => 'image',
            'current_password' => 'required',
            'new_password' => ['required', 'string', 'min:8', 
            'regex:/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/'],
            'confirm_password' => ['required', 'same:new_password'],
        ]);
    }

    public function render()
    {
        return view('livewire.admin.settings.settings-tab.settings-tab3');
    }
}