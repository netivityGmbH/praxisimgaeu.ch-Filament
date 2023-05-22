<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationGroup = "Sensopro";
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = "heroicon-o-key";

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("key")
                    ->label("Schlüssel")
                    ->weight("bold")
                    ->searchable(),
                TextColumn::make("events_count")
                    ->counts("events")
                    ->label("Aktuelle Events")
                    ->grow(false),
                TextColumn::make("total_events")
                    ->label("Max. Events")
                    ->sortable()
                    ->grow(false),
                CheckboxColumn::make("active")->label("Aktiv"),
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
            "index" => Pages\ListSubscriptions::route("/"),
        ];
    }
}
