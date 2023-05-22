<?php

namespace App\Filament\Resources;

use App\Actions\TriggerCircleCiPipeline;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationGroup = "News";
    protected static ?string $navigationIcon = "heroicon-o-calendar";

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make("title"),
            Select::make("type")
                ->options([
                    "info" => "Info",
                    "warning" => "Warnung",
                    "danger" => "Dringend",
                ])
                ->required(),
            RichEditor::make("content")
                ->disableAllToolbarButtons()
                ->enableToolbarButtons([
                    "bold",
                    "italic",
                    "strike",
                    "bulletList",
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BadgeColumn::make("type")
                    ->enum([
                        "info" => "Info",
                        "warning" => "Warnung",
                        "error" => "Dringend",
                    ])
                    ->colors([
                        "primary" => "info",
                        "warning" => "warning",
                        "danger" => "error",
                    ])
                    ->sortable(),
                Stack::make([
                    Panel::make([
                        TextColumn::make("title")
                            ->weight("bold")
                            ->size("lg"),
                        TextColumn::make("content")
                            ->html()
                            ->searchable(),
                    ])->collapsible(),
                ]),
                TextColumn::make("created_at")
                    ->label("Erstellt")
                    ->since()
                    ->size("sm"),
            ])
            ->defaultSort("created_at", "desc")

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->after(function () {
                    TriggerCircleCiPipeline::dispatch();
                }),
                Tables\Actions\DeleteAction::make()->after(function () {
                    TriggerCircleCiPipeline::dispatch();
                }),
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
            "index" => Pages\ListPosts::route("/"),
            "create" => Pages\CreatePost::route("/create"),
            "edit" => Pages\EditPost::route("/{record}/edit"),
        ];
    }
}
