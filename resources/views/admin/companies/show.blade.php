@extends('layouts.admin')
@section('title', 'Información de empresa')
@section('content')
<a class="admin-link" href="{{ route('admin.companies.index') }}">← Empresas</a><h1>{{ $company['company_name'] }}</h1><p class="admin-subtitle">Información y solicitudes recibidas.</p>
<dl class="admin-details">@foreach(['email' => 'Correo', 'rfc' => 'RFC', 'sector' => 'Sector', 'state' => 'Estado', 'city' => 'Ciudad', 'description' => 'Descripción'] as $key => $label)<div><dt>{{ $label }}</dt><dd>{{ $company[$key] ?: 'Sin registrar' }}</dd></div>@endforeach</dl>
<h2>Vacantes registradas</h2><ul class="admin-vacancies">@forelse($vacancies as $vacancy)<li>{{ $vacancy['title'] }} · @include('components.admin.status', ['status' => $vacancy['status']])</li>@empty<li>La empresa aún no registra vacantes.</li>@endforelse</ul>
<h2>Postulaciones recibidas</h2><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Estudiante</th><th>Vacante</th><th>Estado</th></tr></thead><tbody>@forelse($applications as $application)<tr><td>{{ $application['name'] }}</td><td>{{ $application['vacancy'] }}</td><td>@include('components.admin.status', ['status' => $application['status']])</td></tr>@empty<tr><td colspan="3" class="admin-empty">La empresa aún no recibe postulaciones.</td></tr>@endforelse</tbody></table></div>
@include('components.admin.pagination', ['records' => $applications])
@endsection
