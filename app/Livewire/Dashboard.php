<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public int $totalUser;

    public function mount()
    {
        $this->totalUser = User::where('id', '!=', Auth::id())->count();
    }
    public function render()
    {
        return view('livewire.dashboard');
        // ->layout('layouts.dashboard');
    }
}
