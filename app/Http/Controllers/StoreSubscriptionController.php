<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreSubscriptionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json("test", 201);

        $validator = Validator::make($request->all(), [
            "email" => ["required", "email:rfc,dns"],
            "total_events" => ["required", "integer", Rule::in([1, 6, 12, 24])],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        Subscription::create([
            "key" => strtoupper("PIG-" . Str::random(5) . "-" . Str::random(5)),
            "total_events" => $validated["total_events"],
        ]);

        /*
        Mail::to($validated["email"])->send(
            new CustomerSubscriptionConfirmation($newSubscription)
        );
        Mail::to(env("MAIL_DEFAULT_RECIPIENT", "info@netivity.ch"))->send(
            new PraxisSubscriptionNotification($newSubscription)
        );
*/
        return response()->json($validated, 201);
    }
}
