<?php

namespace App\Filament\Resources\MeetingResource\Pages;

use App\Filament\Resources\MeetingResource;
use App\Models\Meeting;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\EditRecord;

class EditMeeting extends EditRecord
{
    protected static string $resource = MeetingResource::class;

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
