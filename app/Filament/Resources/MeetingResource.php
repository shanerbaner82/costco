<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeetingResource\Pages;
use App\Filament\Resources\MeetingResource\RelationManagers\ProductsRelationManager;
use App\Filament\Resources\MeetingResource\RelationManagers\VendorsRelationManager;
use App\Models\Meeting;
use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?int $navigationSort = -1;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->inlineLabel()
            ->schema([
                Select::make('region_id')
                    ->relationship('region', 'name')
                    ->required()
                    ->preload()
                    ->searchable()
                    ->rules('required'),
                Select::make('department_id')
                    ->relationship('department', 'name')
                    ->required()
                    ->preload()
                    ->searchable()
                    ->live()
                    ->rules('required'),
                Select::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Samples' => 'Dropped off samples',
                        'Scheduled' => 'Scheduled',
                        'Active' => 'Active',
                        'Completed' => 'Completed',
                    ])
                    ->live()
                    ->required()
                    ->rules('required'),
                Select::make('buyers')
                    ->multiple()
                    ->disabled(fn(Get $get) => !$get('department_id'))
                    ->preload()
                    ->searchable()
                    ->relationship(
                        titleAttribute: 'name_position',
                        modifyQueryUsing: fn(Builder $query, Get $get) => $query
                            ->where('department_id', $get('department_id'))
                            ->where('region_id', $get('region_id')),
                    )
                    ->required(),
                Select::make('users')
                    ->label('Sales Team')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->relationship(
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query) => User::role('sales'),
                    )
                    ->rules('required'),
                Select::make('vendors')
                    ->relationship('vendors', 'name')
                    ->preload()
                    ->searchable()
                    ->multiple()
                    ->required(),
                CheckboxList::make('products')
                    ->disabled(fn(Get $get) => !$get('department_id'))
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => " ({$record->vendor->name}) {$record->name}")
                    ->relationship(
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query, Get $get) => $query
                            ->whereIn('vendor_id', $get('vendors'))
                            ->where('department_id', $get('department_id'))
                            ->where('is_active', true),
                    ),
                DateTimePicker::make('kitchen_time')
                    ->native(false)
                    ->label('Kitchen Time')
                    ->required(fn (Get $get) => $get('status') !== "Pending")
                    ->reactive()
                    ->seconds(false)
                    ->minutesStep(15)
                    ->default(now()->startOfHour())
                    ->prefixIcon('heroicon-m-calendar')
                    ->live()
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        $set('start_time', Carbon::parse($state)->addMinutes(30));
                        $set('end_time', Carbon::parse($state)->addMinutes(90));
                    })
                    ->rules('required'),
                DateTimePicker::make('start_time')
                    ->native(false)
                    ->label('Start Time')
                    ->required(fn (Get $get) => $get('status') !== "Pending")
                    ->prefixIcon('heroicon-m-calendar')
                    ->seconds(false)
                    ->minutesStep(15)
                    ->default(fn(Get $get) => $get('kitchen_time') ? Carbon::parse($get('kitchen_time'))->addMinutes(30) : null)
                    ->rules('required'),
                DateTimePicker::make('end_time')
                    ->native(false)
                    ->label('End Time')
                    ->prefixIcon('heroicon-m-calendar')
                    ->seconds(false)
                    ->minutesStep(15)
                    ->default(fn(Get $get) => Carbon::parse($get('kitchen_time'))->addMinutes(90))
                    ->rules('required'),
                RichEditor::make('notes'),
                RichEditor::make('menu'),
                RichEditor::make('shopping_list'),
                RichEditor::make('test_kitchen'),
                RichEditor::make('recap')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('region.name'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Pending' => 'warning',
                        'Samples' => 'warning',
                        'Scheduled' => 'success',
                        'Completed' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('start_time')
                    ->sortable()
                    ->dateTime(format: 'M j, h:i A'),

                Tables\Columns\TextColumn::make('vendors')
                    ->getStateUsing(fn(Meeting $record): array => $record->vendors->pluck('name')->toArray()),


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
            VendorsRelationManager::class,
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
