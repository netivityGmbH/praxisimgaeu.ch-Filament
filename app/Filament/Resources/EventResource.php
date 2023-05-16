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
    protected static ?string $navigationIcon = "heroicon-o-collection";

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("name")->label("Name"),
                TextColumn::make("start")
                    ->date("d.m.Y")
                    ->label("Datum")
                    ->grow(false),
                TextColumn::make("start")
                    ->time("H:i")
                    ->label("Startzeit")
                    ->grow(false),
                TextColumn::make("end")
                    ->time("H:i")
                    ->label("Endzeit")
                    ->grow(false),
            ])
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
