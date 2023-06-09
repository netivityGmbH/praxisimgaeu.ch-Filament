<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Actions\TriggerCircleCiPipeline;
use App\Filament\Resources\PostResource;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function afterCreate(): void
    {
        TriggerCircleCiPipeline::dispatch();
    }
}
