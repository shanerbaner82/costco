<?php
namespace App\Filament\Pages;

use App\Models\Meeting;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class MeetingSampleReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string $view = 'filament.pages.meeting-sample-report';

    protected static ?string $slug = 'sample-report';
    protected static ?string $title = 'Samples Report';

    public Collection $meetings;

    public function mount(): void
    {
        $this->meetings = Meeting::with(['vendors'])
            ->whereIn('status', ['Scheduled', 'Samples'])
            ->orderBy('start_time') // assuming there's a `date` column
            ->get()
            ->filter(fn ($meeting) =>
            $meeting->vendors->filter(fn ($vendor) =>
                ! empty($vendor->pivot->samples)
            )->isNotEmpty()
            );
    }
}
