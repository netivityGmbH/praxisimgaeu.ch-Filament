<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\Post;
use App\Models\Subscription;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make("Anzahl Posts", Post::count())
                ->description("Alle Posts sind veröffentlicht")
                ->descriptionColor("success")
                ->descriptionIcon("heroicon-o-badge-check"),

            Card::make("Anzahl Lizenzen", Subscription::count()),

            Card::make("Anzahl Termine", Event::count()),
        ];
    }
}
