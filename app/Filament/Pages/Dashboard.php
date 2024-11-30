<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CalendatWidget;
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
            CalendatWidget::class,
        ];
    }
}
