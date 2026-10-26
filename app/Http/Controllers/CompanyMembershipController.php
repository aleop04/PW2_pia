<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyMembershipController extends Controller
{
    public function index(Request $request): mixed
    {
        $companyId = (string) $request->user('web')->getKey();
        $currentSubscription = Subscription::where('company_user_id', $companyId)
            ->where('payment_status', 'paid')->where('status', 'active')
            ->where('started_at', '<=', now())->where('ended_at', '>', now())->latest('started_at')->first();
        $orders = Subscription::where('company_user_id', $companyId)->latest()->paginate(10)->withQueryString();
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['current_subscription' => $currentSubscription?->summary($request->user('web')), 'orders' => $orders->through(fn ($order) => $order->summary($request->user('web')))]);
        }

        return view('company.membership', compact('currentSubscription', 'orders'));
    }

    public function catalog(): mixed
    {
        $memberships = Membership::where('active', true)->orderBy('priority')->get();

        return view('company.change-membership', compact('memberships'));
    }

    public function store(Request $request): mixed
    {
        $data = $request->validate([
            'membership_id' => ['required', 'string', 'regex:/^[a-f0-9]{24}$/'],
            'billing_email' => ['required', 'email', 'max:255'],
            'amount' => ['prohibited'], 'company_user_id' => ['prohibited'],
            'status' => ['prohibited'], 'payment_status' => ['prohibited'],
            'card_number' => ['prohibited'], 'cvc' => ['prohibited'],
        ]);
        $membership = Membership::where('active', true)->findOrFail($data['membership_id']);
        $order = Subscription::create([
            'company_user_id' => (string) $request->user('web')->getKey(),
            'membership_id' => (string) $membership->getKey(),
            'membership_code' => $membership->code,
            'membership_name' => $membership->name,
            'membership_benefits' => $membership->benefits,
            'membership_vacancy_limit' => $membership->vacancy_limit,
            'membership_priority' => $membership->priority,
            'amount' => $membership->price,
            'currency' => 'MXN',
            'billing_email' => $data['billing_email'],
            'reference' => 'NS-'.Str::upper((string) Str::uuid()),
            'payment_status' => 'pending',
            'status' => 'pending',
        ]);
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($order->summary($request->user('web')), 201);
        }

        return redirect()->route('company.membership')->with('success', 'Solicitud registrada. El pago está pendiente de confirmación.');
    }

    public function cancel(Request $request, string $id): mixed
    {
        $companyId = (string) $request->user('web')->getKey();
        $order = Subscription::where('company_user_id', $companyId)->findOrFail($id);
        $updated = Subscription::where('_id', $id)->where('company_user_id', $companyId)
            ->where('payment_status', 'pending')->update(['payment_status' => 'cancelled', 'status' => 'cancelled']);
        abort_unless($updated, 409, 'Solo se pueden cancelar solicitudes pendientes.');
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($order->fresh()->summary($request->user('web')));
        }

        return back()->with('success', 'Solicitud pendiente cancelada.');
    }
}
