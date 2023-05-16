<?php

namespace App\Actions;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class TriggerCircleCiPipeline
{
    public static function dispatch(): Response
    {
        return Http::withHeaders([
            "Circle-Token" => config("circleci.token"),
        ])->post(config("circleci.url"), [
            "branch" => "master",
        ]);
    }
}
