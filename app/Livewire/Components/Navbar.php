<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Navbar extends Component
{
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.components.navbar');
    }
}
