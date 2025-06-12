<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

#[Title('Register - Create Your Account')]
class Register extends Component
{
    #[Rule('required|string|max:255|min:2')]
    public string $name = '';

    #[Rule('required|string|max:255|min:2')]
    public string $company = '';

    #[Rule('required|string|email|max:255|unique:users')]
    public string $email = '';

    #[Rule('required|min:8')]
    public string $password = '';

    #[Rule('required|same:password')]
    public string $confirmPassword = '';


    public bool $showPassword = false;
    public bool $isLoading = false;


    public function validatePassword() {}

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function register()
    {
        $this->isLoading = true;

        try {
            $validated = $this->validate();


            User::create([
                'name' => $validated['name'],
                'company' => $validated['company'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' =>  'Account created successfully!',
            ]);

            return redirect()->intended('/login');
        } catch (\Exception $e) {

            $this->dispatch('showToast', [
                'type' => 'error',
                'message' =>  'Registration failed. Please try again.',
            ]);
            Log::error('Registration error: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('components.layouts.guest');
    }
}
