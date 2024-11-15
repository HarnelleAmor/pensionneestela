<?php

namespace App\Livewire;

use Livewire\Component;
use OwenIt\Auditing\Models\Audit;

class Audits extends Component
{
    public $audits;

    public function mount()
    {
        $this->audits = Audit::with('user')->oldest()->get();
        // foreach($this->audits as $audit)
        // {
        //     if (is_null($audit->user_id))
        //     {
        //         dump($audit->new_values['id']);
        //     }
        // }
        // dd();
    }
    public function render()
    {
        return view('livewire.audits');
    }
}
