<?php

namespace App\Filament\Widgets;

use App\Models\Meeting;
use App\Models\Region;
use App\Models\Vendor;
use Filament\Widgets\Widget;
use Guava\Calendar\Widgets\CalendarWidget;
use Illuminate\Support\Collection;

class CalendatWidget extends Widget
{
    public $regions;
    public $vendors;

    protected int | string | array $columnSpan = 'full';

    protected static string $view = 'livewire.snapshot';

    public function mount()
    {
        $this->regions = Region::get();
        $this->vendors = Vendor::get();
    }

}
