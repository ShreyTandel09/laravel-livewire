<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Profile extends Component
{
    public int $userId;
    #[Rule('required|string|max:255|min:2')]
    public string $name = '';
    public string $phone_number = '';
    public string $company = '';
    public string $address = '';


    public function mount()
    {
        $this->userId = Auth::id();
    }

    public function updateProfile($data)
    {


        // Log::info('Livewire called:', $data); // Check storage/logs/laravel.log
        $validated = validator($data, [
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
        ])->validate();

        User::findOrFail($this->userId)->update($validated);

        session()->flash('message', 'Profile updated successfully.');

        return redirect()->intended('/dashboard');
    }


    public function render()
    {

        return view('livewire.user.profile');
    }
}
