<?php

namespace App\Livewire\Auth;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Login extends Component
{
    use LivewireAlert;

    public $email, $password, $remember_me, $previous_url, $url_base;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            $this->alert('success', 'Login berhasil');

            if($this->previous_url != $this->url_base . '/login' && (substr($this->previous_url, 0, strlen($this->url_base)) == $this->url_base)){
                return redirect($this->previous_url);
            }

            return redirect()->route('dashboard');
        }else{
            $this->alert('error', 'Email atau password salah');
        }

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->email = '';
        $this->password = '';
        $this->remember_me = false;
    }

    public function mount()
    {
        $this->previous_url = url()->previous();
        $this->url_base = url('/');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.default', ['title' => 'Login']);
    }
}
