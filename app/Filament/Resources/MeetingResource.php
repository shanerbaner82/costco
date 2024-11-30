<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeetingResource\Pages;
use App\Filament\Resources\MeetingResource\RelationManagers\ProductsRelationManager;
use App\Models\Meeting;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class MeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Select::make('region_id')
                    ->relationship('region', 'name')
                    ->required()
                    ->preload()
                    ->searchable()
                    ->rules('required'),
                DateTimePicker::make('kitchen_time')
                    ->label('Kitchen Time')
                    ->native(false)
                    ->required()
                    ->seconds(false)
                    ->minutesStep(15)
                    ->default(now()->startOfHour())
                    ->live()
                    ->rules('required'),
                DateTimePicker::make('start_time')
                    ->label('Start Time')
                    ->native(false)
                    ->required()
                    ->seconds(false)
                    ->minutesStep(15)
                    ->default(fn(Get $get) => Carbon::parse($get('kitchen_time'))->addMinutes(30))
                    ->rules('required'),

                Select::make('vendors')
                    ->multiple()
                    ->live()
                    ->preload()
                    ->searchable()
                    ->relationship(
                        titleAttribute: 'name',
                    )
                    ->required(),
                Select::make('department_id')
                    ->relationship('department', 'name')
                    ->required()
                    ->preload()
                    ->searchable()
                    ->live()
                    ->rules('required'),
                Select::make('status')
                    ->options([
                        'Not Scheduled' => 'Not Scheduled',
                        'Scheduled' => 'Scheduled',
                        'Active' => 'Active',
                        'Completed' => 'Completed',
                    ])
                    ->required()
                    ->rules('required'),
                Select::make('products')
                    ->multiple()
                    ->disabled(fn (Get $get) => ! $get('department_id') )
                    ->preload()
                    ->searchable()
                    ->relationship(
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query, Get $get) =>
                            $query
                                ->where('department_id', $get('department_id'))
                                ->whereIn('vendor_id', $get('vendors'))
                                ->where('is_active', true),
                    )
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Not Scheduled' => 'gray',
                        'Scheduled' => 'warning',
                        'Active' => 'success',
                        'Completed' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('start_time')
                    ->sortable()
                    ->dateTime(format: 'M j, h:i A'),

                Tables\Columns\TextColumn::make('vendors')
                    ->getStateUsing(fn (Meeting $record): array => $record->vendors->pluck('name')->toArray()),

                Tables\Columns\TextColumn::make('region.name'),
                Tables\Columns\TextColumn::make('department.name'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Not Scheduled' => 'Not Scheduled',
                        'Scheduled' => 'Scheduled',
                        'Active' => 'Active',
                        'Completed' => 'Completed',
                    ]),
            ])
            ->defaultSort('start_time')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeetings::route('/'),
            'create' => Pages\CreateMeeting::route('/create'),
            'edit' => Pages\EditMeeting::route('/{record}/edit'),
        ];
    }
}
