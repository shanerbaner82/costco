<?php

namespace App\Filament\Resources\MeetingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $title = 'Buy Docs';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('vendor.name'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\ToggleColumn::make('not_needed')
                    ->afterStateUpdated(function (Set $set, ?string $state, $record) {
                        $record->pivot->update([
                            'requested' => false,
                            'sent' => false,
                            'follow_up' => false,
                        ]);
                    })
                    ->label('Not needed'),
                Tables\Columns\CheckboxColumn::make('requested')
                    ->disabled(fn($record) => $record->pivot->not_needed)
                    ->afterStateUpdated(function (Set $set, ?string $state, $record) {
                        $record->pivot->update([
                            'not_needed' => false,
                        ]);
                    })
                    ->label('Requested'),
                Tables\Columns\CheckboxColumn::make('sent')
                    ->disabled(fn($record) => $record->pivot->not_needed)
                    ->afterStateUpdated(function (Set $set, ?string $state, $record) {
                        $record->pivot->update([
                            'not_needed' => false,
                        ]);
                    })
                    ->label('Sent'),
                Tables\Columns\CheckboxColumn::make('follow_up')
                    ->disabled(fn($record) => $record->pivot->not_needed)
                    ->afterStateUpdated(function (Set $set, ?string $state, $record) {
                        $record->pivot->update([
                            'not_needed' => false,
                        ]);
                    })
                    ->label('Follow Up'),
            ]);
    }
}
