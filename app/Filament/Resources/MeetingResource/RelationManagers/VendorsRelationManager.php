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
            ]);
    }
}
