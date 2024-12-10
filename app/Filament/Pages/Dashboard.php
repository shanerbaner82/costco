<?php

namespace App\Filament\Pages;

use App\Filament\Resources\MeetingResource\Widgets\CalendarTableWidget;
use App\Filament\Widgets\CalendarWidget;
use Filament\Pages\Dashboard as FilamentDashboard;

class Dashboard extends FilamentDashboard
{

    public function getColumns(): int | string | array
    {
        return 1;
    }

    public function getWidgets(): array
    {
        return [
            CalendarTableWidget::class,
            CalendarWidget::class
        ];
    }
}
