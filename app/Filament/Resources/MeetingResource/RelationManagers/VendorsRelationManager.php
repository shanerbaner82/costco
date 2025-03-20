<?php

namespace App\Filament\Resources\MeetingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VendorsRelationManager extends RelationManager
{
    protected static string $relationship = 'vendors';

    protected static ?string $title = 'Samples';

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->inlineLabel()
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Vendor')
                    ->disabled()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('samples')
                    ->formatStateUsing(function($state){
                        if(!$state) {
                            return '<p><b>Ship:</b></p><p><b>Delivery:</b></p><br/><p><b>Please Ship To: </b></p>';
                        }
                        return $state;
                    })
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->grow(false),
                Tables\Columns\TextColumn::make('samples')
                    ->html()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Print')
                    ->visible(fn($record) => $record->samples)
                    ->url(fn($record) => route('print-samples', ['vendor' => $record, 'meeting' => $this->ownerRecord->id]))
                    ->icon('heroicon-o-printer')
            ]);
    }
}
