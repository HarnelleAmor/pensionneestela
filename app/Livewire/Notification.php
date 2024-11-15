<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notification extends Component
{
    public $notifications;
    public User $user;

    public function mount()
    {
        $this->user = Auth::user();
        $this->refreshNotifs();
        
        // dd($this->notifications);
    }

    public function getListeners()
    {
        return [
            "echo-private:users." . Auth::id() . ",example" => 'newNotif'
        ];
    }

    public function newNotif()
    {
        $this->refreshNotifs();
        $this->dispatch('newToast');
    }

    public function refreshNotifs()
    {
        $this->notifications = $this->user->unreadNotifications()->take(20)->get();
        foreach ($this->notifications as $notification) {
            $notification->time_interval = Carbon::parse($notification->created_at)->diffForHumans();
        }
    }

    public function mark($id)
    {
        $notif = $this->user->unreadNotifications->where('id', $id)->first();
        if ($notif) {
            try {
                $notif->markAsRead();
                $this->dispatch('markSuccess', id: $id, title: 'Notification marked as read!');
            } catch (\Exception $e) {
                $this->dispatch('markError', id: $id, title: 'Error in marking notification!');
            }
        } else {
            $this->dispatch('markError', id: $id, title: 'Can\'t mark notification!');
        }
    }

    public function markAll()
    {
        try {
            $this->user->unreadNotifications->markAsRead();
            $this->refreshNotifs();
            $this->dispatch('markAllSuccess');
        } catch (\Exception $e) {
            $this->dispatch('markAllError');
        }
    }

    public function render()
    {
        return view('livewire.notification');
    }
}
