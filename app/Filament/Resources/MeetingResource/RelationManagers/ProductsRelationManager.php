<?php

namespace App\Filament\Resources\MeetingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $title = 'Buy Docs';

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->inlineLabel()
            ->schema([
                Toggle::make('not_needed')
                    ->live()
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        $set('requested_at', null);
                        $set('sent_at', null);
                        $set('follow_up_at', null);
                    })
                    ->label('Not Needed')
                    ->default(false),
                Forms\Components\DatePicker::make('requested_at')
                    ->label('Requested')
                    ->seconds(false)
                    ->default(now())
                    ->native(false),
                Forms\Components\DatePicker::make('sent_at')
                    ->label('Sent')
                    ->seconds(false)
                    ->default(now())
                    ->native(false),
                Forms\Components\DatePicker::make('follow_up_at')
                    ->label('Followed Up')
                    ->seconds(false)
                    ->default(now())
                    ->native(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('vendor.name'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\IconColumn::make('not_needed')
                    ->boolean()
                    ->label('Needed')
                    ->sortable(),
                Tables\Columns\TextColumn::make('requested_at')
                    ->dateTime()
                    ->label('Requested At')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sent_at')
                    ->dateTime()
                    ->label('Sent At')
                    ->sortable(),
                Tables\Columns\TextColumn::make('follow_up_at')
                    ->dateTime()
                    ->label('Follow Up At')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->visible(fn($record) => $record->buy_doc_url)
                    ->url(fn($record) => Storage::disk('public')->url($record->buy_doc_url))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('buy_doc_url')
                    ->icon('heroicon-o-printer')
                    ->label('Upload Buy Doc')
                    ->button()
                    ->form([
                        Forms\Components\FileUpload::make('buy_doc_url')
                            ->disk('public')
                            ->label('Buy Doc')
                            ->maxFiles(1)
                            ->preserveFilenames()
                            ->openable()
                            ->directory('buy_docs')
                            ->required()
                        ,
                    ])
                    ->action(function (array $data, $record): void {
                        $record->pivot->update(['buy_doc_url' => $data['buy_doc_url']]);
                    })
            ]);
    }
}
