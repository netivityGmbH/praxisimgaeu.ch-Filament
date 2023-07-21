<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationGroup = "Sensopro";
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = "heroicon-o-calendar";
    protected static ?string $navigationLabel = "Termine";

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("subscription.firstname")
                    ->label("Vorname")
                    ->searchable(),
                TextColumn::make("subscription.lastname")
                    ->label("Nachname")
                    ->searchable(),
                TextColumn::make("subscription.key")
                    ->label("Schlüssel")
                    ->searchable(),
                TextColumn::make("name")->label("Name"),
                TextColumn::make("start")
                    ->dateTime("d.m.Y H:i")
                    ->label("Startzeit")
                    ->grow(false),
                TextColumn::make("end")
                    ->time("H:i")
                    ->label("Endzeit")
                    ->grow(false),
            ])
            ->defaultSort("created_at", "desc")
            ->actions([Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
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
            "index" => Pages\ListEvents::route("/"),
        ];
    }
}
