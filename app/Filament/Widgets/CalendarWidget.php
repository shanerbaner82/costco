<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\MeetingResource;
use App\Models\Meeting;
use Filament\Actions\Action;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    protected function headerActions(): array
    {
        return [
            Action::make('create')
                ->label('New')
                ->url(MeetingResource::getUrl('create')),
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Meeting::query()
            ->where('meeting_date', '>=', $fetchInfo['start'])
            ->get()
            ->map(
                fn (Meeting $meeting) => [
                    'title' => '(' . str($meeting->status)->substr(0, 1) . ') ' . $meeting->region->name . ' ' .$meeting->department->name,
                    'start' => Carbon::parse($meeting->meeting_date->format('m/d/y') . ' ' . $meeting->start_time?->format('h:i a')),
                    'end' => $meeting->end_time,
                    'url' => route('filament.admin.resources.meetings.edit', ['record' => $meeting]),
                ]
            )
            ->all();
    }
}
