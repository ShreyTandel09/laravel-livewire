<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public int $totalUser;
    public string $usersGrowth;
    public int $revenue;
    public string $revenueGrowth;
    public int $orders;
    public string $ordersGrowth;
    public int $conversionRate;
    public string $conversionGrowth;

    public function mount()
    {
        $this->totalUser = User::where('id', '!=', Auth::id())->count();
        $this->usersGrowth = '+12%';
        $this->revenue = 45678;
        $this->revenueGrowth = '+8%';
        $this->orders = 892;
        $this->ordersGrowth = '+15%';
        $this->conversionRate = 3.2;
        $this->conversionGrowth = '+0.5%';
    }
    public function render()
    {
        return view('livewire.dashboard');
        // ->layout('layouts.dashboard');
    }
}
