<?php

namespace App\Livewire;

use App\Models\Meeting;
use App\Models\Region;
use App\Models\Vendor;
use Livewire\Component;

class Snapshot extends Component
{
    public function render()
    {

        return view('livewire.snapshot', [
            'regions' => Region::get(),
            'meetings' => Meeting::get(),
            'vendors' => Vendor::get(),
        ]);
    }
}
