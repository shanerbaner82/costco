<?php

namespace App\Filament\Widgets;

use App\Models\Meeting;
use Filament\Widgets\Widget;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
//    protected static string $view = 'filament.widgets.calendar-widget';
    public function fetchEvents(array $fetchInfo): array
    {
        return Meeting::query()
            ->where('start_time', '>=', $fetchInfo['start'])
            ->whereStatus('Scheduled')
            ->get()
            ->map(
                fn (Meeting $meeting) => [
                    'title' => $meeting->department->name,
                    'start' => $meeting->kitchen_time,
                    'end' => $meeting->start_time,
                    'url' => route('filament.admin.resources.meetings.edit', ['record' => $meeting]),
                ]
            )
            ->all();
    }
}
