@extends('layouts.company')
@section('content')
<section class="membership-page">
<div class="membership-page__header"><h1>Tu suscripción</h1><p>Información de tu membresía e historial de compras.</p></div>
<div class="ns-membership-content">
@if(session('success'))<p class="admin-feedback" role="status">{{ session('success') }}</p>@endif
@if($currentSubscription)
<div class="membership-page__current"><div class="membership-page__current-info"><h2>{{ $currentSubscription->membership_name ?? 'Membresía activa' }} · ${{ number_format($currentSubscription->amount, 2) }} {{ $currentSubscription->currency ?? '' }}</h2><p>Vigente hasta {{ $currentSubscription->ended_at->format('d/m/Y') }}</p></div></div>
<div class="membership-benefits membership-benefits--plus" style="margin-top:25px"><div class="membership-benefits__header"><h2>Beneficios de tu compra</h2><a class="membership-benefits__change" href="{{ route('company.membership.change') }}">Ver catálogo →</a></div><ul class="membership-benefits__list">@foreach($currentSubscription->membership_benefits ?? [] as $benefit)<li class="membership-benefits__item"><span>{{ $benefit }}</span></li>@endforeach</ul></div>
@else<p class="admin-note">Aún no tienes una membresía pagada y vigente.</p><a class="admin-button admin-button--primary" href="{{ route('company.membership.change') }}">Ver membresías</a>@endif
<div class="ns-order-history"><h2>Historial de solicitudes y pagos</h2><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Plan / referencia</th><th>Importe</th><th>Pago</th><th>Acciones</th></tr></thead><tbody>
@forelse($orders as $order)<tr><td><strong>{{ $order->membership_name ?? 'Plan sin nombre histórico' }}</strong><small>{{ $order->reference ?: $order->getKey() }}</small>@if($order->payment_method === 'simulation')<small>Simulación · sin cobro real</small>@endif</td><td>${{ number_format($order->amount, 2) }} {{ $order->currency ?? 'Sin registrar' }}</td><td>@include('components.admin.status', ['status' => $order->payment_status])</td><td>@if($order->payment_status === 'pending')<form method="POST" action="{{ route('company.membership.orders.cancel', $order->getKey()) }}">@csrf @method('PATCH')<button class="admin-link" type="submit">Cancelar solicitud</button></form>@else—@endif</td></tr>
@empty<tr><td colspan="4" class="admin-empty">Todavía no tienes solicitudes de compra.</td></tr>@endforelse</tbody></table></div>@include('components.admin.pagination', ['records' => $orders])</div>
</div></section>
@endsection
