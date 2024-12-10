<?php

namespace App\Filament\Resources\MeetingResource\Widgets;

use App\Filament\Resources\MeetingResource;
use App\Models\Meeting;
use App\Models\Region;
use App\Models\Vendor;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class CalendarTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Vendor Meetings by Region';

    public function table(Table $table): Table
    {
        $regions = Region::all();

        $selects = $regions->map(function ($region) {
            return "(SELECT GROUP_CONCAT(
                        CONCAT(
                            DATE_FORMAT(meetings.start_time, '%b %d'),
                            ' ',
                            departments.name,
                            '<br>'
                        ) SEPARATOR ''
                    )
                    FROM meetings
                    JOIN meeting_vendor ON meetings.id = meeting_vendor.meeting_id
                    JOIN departments ON meetings.department_id = departments.id
                    WHERE meeting_vendor.vendor_id = vendors.id
                    AND meetings.region_id = {$region->id}
                   ) as region_{$region->id}_meetings";
        })->join(', ');

        return $table
            ->query(
                Vendor::query()
                    ->select('vendors.*')
                    ->selectRaw($selects)
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Vendor'),
                ...$regions->map(function ($region) {
                    return TextColumn::make("region_{$region->id}_meetings")
                        ->label($region->name)
                        ->html();
                })
            ])
            ->paginated(false);
    }
}


