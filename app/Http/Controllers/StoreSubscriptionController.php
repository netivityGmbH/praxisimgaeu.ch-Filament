<?php

namespace App\Http\Controllers;

use App\Mail\CompanySubscriptionConfirmation;
use App\Mail\CustomerSubscriptionConfirmation;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreSubscriptionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "firstname" => ["required", "max:255"],
            "lastname" => ["required", "max:255"],
            "email" => ["required", "email:rfc,dns"],
            "total_events" => ["required", "integer", Rule::in([1, 6, 12, 24])],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        $newSubscription = Subscription::create([
            "firstname" => $validated["firstname"],
            "lastname" => $validated["lastname"],
            "key" => strtoupper("PIG-" . Str::random(5) . "-" . Str::random(5)),
            "total_events" => $validated["total_events"],
        ]);

        Mail::to($validated["email"])->send(
            new CustomerSubscriptionConfirmation($newSubscription)
        );
        Mail::to(config("mail.recipient"))->send(
            new CompanySubscriptionConfirmation($newSubscription)
        );

        return response()->json($validated, 201);
    }
}
