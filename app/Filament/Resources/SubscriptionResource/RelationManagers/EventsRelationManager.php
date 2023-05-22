<?php

namespace App\Filament\Resources\SubscriptionResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventsRelationManager extends RelationManager
{
    protected static string $relationship = "events";

    protected static ?string $recordTitleAttribute = "id";

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
}
