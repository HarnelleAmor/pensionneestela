<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ManagerNotifications extends Component
{
    public $notifications;
    public $user;

    public function mount()
    {
        $this->user = User::find(Auth::id());
        $this->notifications = $this->user->notifications;
    }

    public function render()
    {
        return view('livewire.manager-notifications');
    }
}
