@extends('layouts.company')
@section('content')
<section class="change-membership-page"><div class="ns-catalog">
<a class="admin-link" href="{{ route('company.membership') }}">← Tu suscripción</a>
<h1>Escoge la suscripción deseada</h1><p>Catálogo mensual de membresías · Precios en MXN.</p>
@if($errors->any())<div class="admin-errors" role="alert">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
<form method="POST" action="{{ route('company.membership.orders.store') }}">@csrf
<div class="ns-catalog__plans">@forelse($memberships as $membership)
<label class="ns-catalog__plan"><input type="radio" name="membership_id" value="{{ $membership->getKey() }}" required @checked(old('membership_id') === (string) $membership->getKey())><h2>{{ $membership->name }}</h2><strong>${{ number_format($membership->price, 2) }} / mes</strong><p>{{ $membership->vacancy_limit === null ? 'Vacantes ilimitadas' : $membership->vacancy_limit.' vacantes' }}</p><ul>@foreach($membership->benefits ?? [] as $benefit)<li>{{ $benefit }}</li>@endforeach</ul></label>
@empty<p>No hay membresías disponibles en este momento.</p>@endforelse</div>
@if($memberships->isNotEmpty())<div class="admin-form"><label>Correo para la compra<input type="email" name="billing_email" value="{{ old('billing_email', auth('web')->user()->email) }}" maxlength="255" required></label></div><p class="admin-note">Se registrará una solicitud pendiente. La membresía se activará al confirmar el pago.</p><button class="admin-button admin-button--primary" type="submit">Registrar solicitud de compra</button>@endif
</form></div></section>
@endsection
