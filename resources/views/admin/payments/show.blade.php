@extends('layouts.admin')
@section('title', 'Detalle de pago')
@section('content')
<a class="admin-link" href="{{ route('admin.payments.index') }}">← Pagos</a><h1>Detalle de pago</h1><p class="admin-subtitle">{{ $payment['reference'] ?: $payment['id'] }}</p>
<dl class="admin-details">@foreach(['company_name' => 'Empresa', 'membership_name' => 'Membresía comprada', 'billing_email' => 'Correo de facturación'] as $key => $label)<div><dt>{{ $label }}</dt><dd>{{ $payment[$key] ?: 'Sin registrar' }}</dd></div>@endforeach
<div><dt>Importe</dt><dd>${{ number_format($payment['amount'], 2) }} {{ $payment['currency'] }}</dd></div><div><dt>Estado del pago</dt><dd>@include('components.admin.status', ['status' => $payment['payment_status']])</dd></div><div><dt>Estado registrado de suscripción</dt><dd>@include('components.admin.status', ['status' => $payment['status']])</dd></div>
<div><dt>Método</dt><dd>{{ $payment['payment_method'] === 'simulation' ? 'Simulación académica · sin cobro real' : $payment['payment_method'] }}</dd></div>
@foreach(['created_at' => 'Fecha de solicitud', 'paid_at' => 'Confirmación', 'started_at' => 'Inicio de vigencia', 'ended_at' => 'Fin de vigencia'] as $key => $label)<div><dt>{{ $label }}</dt><dd>{{ $payment[$key] ? \Carbon\Carbon::parse($payment[$key])->format('d/m/Y H:i') : 'Sin registrar' }}</dd></div>@endforeach</dl>
@if($payment['ended_at'] && \Carbon\Carbon::parse($payment['ended_at'])->isPast())<p class="admin-note">La vigencia de esta compra ya terminó.</p>@endif
<p class="admin-note">El importe y los beneficios se conservan tal como se registraron al solicitar la compra.</p>
@endsection
