@extends('layouts.admin')
@section('title', 'Pagos')
@section('content')
<h1>Pagos</h1><p class="admin-subtitle">Consulta las solicitudes de compra y el resultado de cada operación.</p>
<div class="admin-summary">@foreach(['Total pagado · MXN', 'Pagos pendientes', 'Pagos fallidos'] as $index => $label)<div class="admin-stat"><strong>{{ $index === 0 ? '$'.number_format($summary[$index], 2) : $summary[$index] }}</strong><span>{{ $label }}</span></div>@endforeach</div>
<form method="GET" class="admin-toolbar"><label class="admin-search">Empresa o referencia<input name="q" type="search" maxlength="100" value="{{ request('q') }}"></label><label>Estado<select name="payment_status"><option value="">Todos</option>@foreach(['pending' => 'Pendiente', 'paid' => 'Pagado', 'failed' => 'Fallido', 'cancelled' => 'Cancelado'] as $value => $label)<option value="{{ $value }}" @selected(request('payment_status') === $value)>{{ $label }}</option>@endforeach</select></label><label>Desde<input type="date" name="from" value="{{ request('from') }}"></label><label>Hasta<input type="date" name="to" value="{{ request('to') }}"></label><button class="admin-button">Filtrar</button><a class="admin-link" href="{{ route('admin.payments.index') }}">Limpiar</a></form>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Empresa / plan</th><th>Importe</th><th>Fecha</th><th>Estado</th><th>Detalle</th></tr></thead><tbody>
@forelse($payments as $payment)<tr><td><strong>{{ $payment['company_name'] }}</strong><small>{{ $payment['membership_name'] }}</small></td><td>${{ number_format($payment['amount'], 2) }} {{ $payment['currency'] }}</td><td>{{ $payment['created_at'] ? \Carbon\Carbon::parse($payment['created_at'])->format('d/m/Y') : 'Sin registrar' }}</td><td>@include('components.admin.status', ['status' => $payment['payment_status']])</td><td><a class="admin-link" href="{{ route('admin.payments.show', $payment['id']) }}">Ver detalle</a></td></tr>
@empty<tr><td colspan="5" class="admin-empty">No hay pagos que coincidan con los filtros.</td></tr>@endforelse</tbody></table></div>
@include('components.admin.pagination', ['records' => $payments])
@endsection
