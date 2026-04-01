<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegionResource\Pages;
use App\Models\Region;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;

class RegionResource extends Resource
{
    protected static ?string $model = Region::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-globe-americas';

    protected static string|\UnitEnum|null $navigationGroup = 'Setup';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->inlineLabel()
            ->columns(1)
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->rules('required', 'string', 'max:255'),
                TextInput::make('contact_name')
                    ->label('Contact Name')
                    ->rules('string', 'max:255'),
                Select::make('contact_type')
                    ->options([
                        'Buyer' => 'Buyer',
                        'Ass. Buyer' => 'Ass. Buyer',
                        'AGM' => 'AGM',
                        'GM' => 'GM',
                        'Other' => 'Other',
                    ])
                    ->label('Contact Type')
                    ->rules('string', 'max:255'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_name')
                    ->label('Contact Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_type')
                    ->label('Contact Type')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegions::route('/'),
            'create' => Pages\CreateRegion::route('/create'),
            'edit' => Pages\EditRegion::route('/{record}/edit'),
        ];
    }
}
