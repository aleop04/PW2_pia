<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_user_id' => 'required|string',
            'membership_id' => 'required|string',
            'status' => 'required|string',
            'amount' => 'required|numeric',
            'billing_email' => 'required|email',
            'cardholder_name' => 'required|string',
            'billing_country' => 'required|string',
            'billing_postal_code' => 'required|string',
        ]);

        $subscription = Subscription::create($request->all());
        return response()->json($subscription, 201);
    }

    public function index()
    {
        return response()->json(Subscription::all(), 200);
    }

    public function update(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update($request->all());
        return response()->json($subscription, 200);
    }

    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();
        return response()->json(['message' => 'Suscripción eliminada'], 200);
    }
}