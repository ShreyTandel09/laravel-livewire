<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class EditUser extends Component
{

    public bool $showModal = false;

    public ?User $user;

    // Form fields
    public string $name = '';
    public string $email = '';
    public string $company = '';
    public string $address = '';
    public string $phone_number = '';


    #[On('show-user-edit-modal')]
    public function editUser(int $userId): void
    {

        $this->user = User::findOrFail($userId);
        $this->name = isset($this->user->name) ? $this->user->name : '';
        $this->email = $this->user->email;
        $this->company = isset($this->user->company) ? $this->user->company : '';
        $this->address = isset($this->user->address) ? $this->user->address : '';
        $this->phone_number = isset($this->user->phone_number) ? $this->user->phone_number : '';

        $this->showModal = true;
    }

    public function save(): void
    {
        // Basic validation
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);


        if ($this->user) {
            $this->user->update($validated);
        }

        $this->closeModal();

        // Dispatch an event to tell UserTable to refresh
        $this->dispatch('userUpdated');

        $this->dispatch('showToast', [
            'type' => 'success',
            'message' =>  'User updated successfully!',
        ]);
    }


    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(); // Resets public properties to their initial state
    }
    public function render()
    {
        return view('livewire.user.edit-user');
    }
}
