<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

#[Title('Login - login into Your Account')]
class Login extends Component
{
    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required|min:8')]
    public string $password = '';

    public function updatedEmail()
    {
        $this->validateOnly('email');
    }

    public function updatedPassword()
    {
        $this->validateOnly('password');
    }

    public function login()
    {
        try {
            // dd($this);
            if (Auth::attempt([
                'email' => $this->email,
                'password' => $this->password,
            ])) {
                session()->regenerate();
                $this->dispatch('showToast', [
                    'type' => 'success',
                    'message' =>  'Login successful!',
                ]);

                return redirect()->route('dashboard');
            } else {
                $this->dispatch('showToast', [
                    'type' => 'error',
                    'message' => 'Invalid credentials.',
                ]);
                return redirect()->route('login');
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'An unexpected error occurred.');
            throw $th;
        }
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.guest');
        // resources\views\components\layouts\guest.blade.php
    }
}
