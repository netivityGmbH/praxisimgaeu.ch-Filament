<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckSubscriptionStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "key" => ["starts_with:PIG-", "string", "size:15"],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        $subscription = Subscription::where("key", $validated["key"])
            ->withCount("events")
            ->first();

        if (!$subscription["active"]) {
            return response()->json($validator->errors(), 400);
        }

        if (
            is_null($subscription) ||
            $subscription->total_events - $subscription->events_count <= 0
        ) {
            return response()->json("invalid", 201);
        } else {
            return response()->json(
                ["valid", "subscription" => $subscription],
                201
            );
        }
    }
}
