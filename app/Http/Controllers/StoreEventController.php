<?php

namespace App\Http\Controllers;

use App\Mail\CustomerEventConfirmation;
use App\Models\Event;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class StoreEventController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "subscription_id" => ["required", "exists:subscriptions,id"],
            "email" => ["nullable", "email:rfc,dns"],
            "events.*.start" => ["required", "date", "after_or_equal:today"],
            "events.*.end" => ["required", "date"],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();
        $subscription = Subscription::withCount("events")->find(
            $validated["subscription_id"]
        );

        if (!$subscription["active"]) {
            return response()->json($validator->errors(), 400);
        }

        if (
            $subscription["total_events"] -
                $subscription["events_count"] -
                count($validated["events"]) <
            0
        ) {
            return response()->json($validator->errors(), 422);
        }

        foreach ($validated["events"] as $event) {
            $newEvent = new Event([
                "name" => "",
                "start" => $event["start"],
                "end" => $event["end"],
                "subscription_id" => $validated["subscription_id"],
            ]);

            $newEvent->save();
        }

        if ($validated["email"]) {
            Mail::to($validated["email"])->send(
                new CustomerEventConfirmation(
                    $validated["events"],
                    $validated["subscription_id"]
                )
            );

            return response()->json("mail_sent", 201);
        } else {
            return response()->json("no_mail", 201);
        }
    }
}
