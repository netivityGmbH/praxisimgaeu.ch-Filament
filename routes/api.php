<?php

use App\Http\Controllers\CheckSubscriptionStatusController;
use App\Http\Controllers\StoreEventController;
use App\Models\Event;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/*
Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});
*/

Route::get("/posts", function () {
    return Post::orderBy("created_at", "desc")->get();
});

Route::prefix("subscriptions")->group(function () {
    Route::post("/check", CheckSubscriptionStatusController::class);
});

Route::prefix("events")->group(function () {
    Route::get("/", function () {
        return Event::orderBy("start", "desc")->get();
    });

    Route::post("/", StoreEventController::class);
});
