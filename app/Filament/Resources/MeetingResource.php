<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeetingResource\Pages;
use App\Filament\Resources\MeetingResource\RelationManagers\ProductsRelationManager;
use App\Filament\Resources\MeetingResource\RelationManagers\VendorsRelationManager;
use App\Models\Meeting;
use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
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
use Filament\Tables\Actions\Action;
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
                DatePicker::make('meeting_date')
                    ->label('Meeting Date')
                    ->required()
                    ->native(false)
                    ->prefixIcon('heroicon-m-calendar')
                    ->minutesStep(15),
                Select::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Samples' => 'Dropped off samples',
                        'Scheduled' => 'Scheduled',
                        'Active' => 'Active',
                        'Completed' => 'Completed',
                    ])
                    ->live(),
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
                    ),
                Select::make('users')
                    ->label('Sales Team')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->relationship(
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query) => User::role('sales'),
                    ),
                Select::make('vendors')
                    ->relationship('vendors', 'name')
                    ->live()
                    ->preload()
                    ->searchable()
                    ->multiple()
                    ->required(),
                Select::make('products')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->disabled(fn(Get $get) => !$get('department_id'))
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => " ({$record->vendor->name}) {$record->name}")
                    ->relationship(
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query, Get $get) => $query
                            ->whereIn('vendor_id', $get('vendors'))
                            ->where('department_id', $get('department_id'))
                            ->where('is_active', true)
                            ->orderBy('name'),
                    ),
                DateTimePicker::make('kitchen_time')
                    ->label('Kitchen Time')
                    ->date(false)
                    ->seconds(false)
                    ->minutesStep(15)
                    ->prefixIcon('heroicon-m-calendar'),
                DateTimePicker::make('start_time')
                    ->label('Start Time')
                    ->prefixIcon('heroicon-m-calendar')
                    ->seconds(false)
                    ->date(false)
                    ->minutesStep(15),
                DateTimePicker::make('end_time')
                    ->label('End Time')
                    ->date(false)
                    ->prefixIcon('heroicon-m-calendar')
                    ->seconds(false)
                    ->minutesStep(15),
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->defaultSort('start_time')
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button(),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->visible(fn($record) => $record->status !== 'Completed'),
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
