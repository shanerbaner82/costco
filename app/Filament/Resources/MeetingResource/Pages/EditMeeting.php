<?php

namespace App\Filament\Resources\MeetingResource\Pages;

use App\Filament\Resources\MeetingResource;
use App\Models\Meeting;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Carbon;

class EditMeeting extends EditRecord
{
    protected static string $resource = MeetingResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $meeting = Carbon::parse($data['meeting_date'])->format('m/d/Y');

        if(isset($data['kitchen_time'])) {
            $data['kitchen_time'] = Carbon::make($meeting . ' ' . Carbon::parse($data['kitchen_time'])->format('H:i:s'));
        }

        if(isset($data['start_time'])) {
            $data['start_time'] = Carbon::make($meeting . ' ' . Carbon::parse($data['start_time'])->format('H:i:s'));
        }
        if(isset($data['end_time'])) {
            $data['end_time'] = Carbon::make($meeting . ' ' . Carbon::parse($data['end_time'])->format('H:i:s'));
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [

            ActionGroup::make([
                Actions\Action::make('print')
                    ->label('Notes')
                    ->hidden(fn($record) => !$record->notes)
                    ->url(fn($record) => route('print', [
                        'meeting' => $record->id,
                        'type' => 'Notes',
                        'data' => $record->notes,
                    ]))
                    ->color('primary'),
                Actions\Action::make('print')
                    ->label('Shopping List')
                    ->hidden(fn($record) => !$record->shopping_list)
                    ->url(fn($record) => route('print', [
                        'meeting' => $record->id,
                        'type' => 'Shopping List',
                        'data' => $record->shopping_list,
                    ]))
                    ->color('primary'),
                Actions\Action::make('print')
                    ->label('Menu')
                    ->hidden(fn($record) => !$record->menu)
                    ->url(fn($record) => route('print', [
                        'meeting' => $record->id,
                        'type' => 'Menu',
                        'data' => $record->menu,
                    ]))
                    ->color('primary'),
                Actions\Action::make('print')
                    ->label('Test Kitchen')
                    ->hidden(fn($record) => !$record->test_kitchen)
                    ->url(fn($record) => route('print', [
                        'meeting' => $record->id,
                        'type' => 'Test Kitchen',
                        'data' => $record->test_kitchen,
                    ]))
                    ->color('primary'),
                Actions\Action::make('print')
                    ->label('Samples')
                    ->hidden(fn($record) => !$record->samples)
                    ->url(fn($record) => route('print', [
                        'meeting' => $record->id,
                        'type' => 'Samples',
                        'data' => $record->samples,
                    ]))
                    ->color('primary'),
                Actions\Action::make('print')
                    ->hidden(fn($record) => !$record->recap)
                    ->label('Recap')
                    ->url(fn($record) => route('print', [
                        'meeting' => $record->id,
                        'type' => 'Recap',
                        'data' => $record->recap,
                    ]))
                    ->color('primary'),
            ])
                ->button()
                ->color('primary')
                ->icon('heroicon-o-printer')
                ->label('Print'),
        ];
    }
}
