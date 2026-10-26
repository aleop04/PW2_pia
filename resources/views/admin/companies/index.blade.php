@extends('layouts.admin')
@section('title', 'Empresas')
@section('content')
<h1>Empresas</h1><p class="admin-subtitle">Información empresarial, vacantes y postulaciones recibidas.</p>
<div class="admin-summary">@foreach(['Empresas registradas', 'Vacantes registradas', 'Postulaciones recibidas'] as $index => $label)<div class="admin-stat"><strong>{{ $summary[$index] }}</strong><span>{{ $label }}</span></div>@endforeach</div>
<form method="GET" class="admin-toolbar"><label class="admin-search">Empresa o RFC<input type="search" name="q" maxlength="100" value="{{ request('q') }}" placeholder="Buscar empresa"></label><button class="admin-button">Buscar</button><a class="admin-link" href="{{ route('admin.companies.index') }}">Limpiar</a></form>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Empresa</th><th>RFC</th><th>Postulaciones</th><th>Acciones</th></tr></thead><tbody>
@forelse($companies as $company)<tr><td><strong>{{ $company['company_name'] }}</strong><small>{{ $company['email'] }}</small></td><td>{{ $company['rfc'] }}</td><td>{{ $company['application_count'] }}</td><td><a class="admin-link" href="{{ route('admin.companies.show', $company['id']) }}">Ver empresa</a></td></tr>
@empty<tr><td colspan="4" class="admin-empty">No hay empresas que coincidan con la búsqueda.</td></tr>@endforelse
</tbody></table></div>@include('components.admin.pagination', ['records' => $companies])
@endsection
