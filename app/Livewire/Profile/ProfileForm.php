<?php

namespace App\Livewire\Profile;

use App\Livewire\BaseComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProfileForm extends BaseComponent
{
    use LivewireAlert;

    public $user;
    public $name, $email, $password, $password_confirm, $password_string;

    public $passwordShow = false;
    public $passwordConfirmShow = false;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'nullable|min:6',
        'password_confirm' => 'nullable|same:password',
    ];

    protected $messages = [
        'name.required' => 'Nama wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Email tidak valid',
        'password.min' => 'Password minimal 6 karakter',
        'password_confirm.same' => 'Password tidak sama dengan konfirmasi password',
    ];

    public function mount()
    {
        $this->name = $this->authUser->name;
        $this->email = $this->authUser->email;
        // $this->password = $this->authUser->password;
        // $this->password_string = $this->authUser->password_string;
    }

    public function togglePassword()
    {
        $this->passwordShow = !$this->passwordShow;
    }

    public function togglePasswordConfirm()
    {
        $this->passwordConfirmShow = !$this->passwordConfirmShow;
    }

    public function resetForm()
    {
        $this->name = $this->authUser->name;
        $this->email = $this->authUser->email;
        $this->password = '';
        $this->password_confirm = '';
        $this->password_string = '';
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function submit()
    {
        $this->validate();

        try {
            $this->password_string = $this->password;
            $this->password = bcrypt($this->password_string);
            
            $this->authUser->update([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'password_string' => $this->password_string
            ]);

            $this->resetForm();

            $this->alert('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            $this->alert('error', 'Failed to update profile');
        }
    }

    public function render()
    {
        return view('livewire.profile.profile-form');
    }
}
