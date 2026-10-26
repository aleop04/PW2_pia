@extends('layouts.admin')
@section('title', 'Membresías')
@section('content')
<h1>Membresías</h1><p class="admin-subtitle">Administra el catálogo que verán las empresas.</p>
<div class="admin-summary">@foreach(['Planes en el catálogo', 'Visibles para empresas', 'Planes inactivos'] as $index => $label)<div class="admin-stat"><strong>{{ $summary[$index] }}</strong><span>{{ $label }}</span></div>@endforeach</div>
<form method="GET" class="admin-toolbar"><label class="admin-search">Nombre<input type="search" name="q" maxlength="100" value="{{ request('q') }}" placeholder="Buscar membresía"></label><label>Estado<select name="active"><option value="">Todas</option><option value="1" @selected(request('active') === '1')>Activas</option><option value="0" @selected(request('active') === '0')>Inactivas</option></select></label><button class="admin-button">Filtrar</button><a class="admin-button admin-button--primary" href="{{ route('admin.memberships.create') }}">+ Crear membresía</a></form>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Membresía</th><th>Precio mensual</th><th>Vacantes</th><th>Estado</th><th>Acciones</th></tr></thead><tbody>
@forelse($memberships as $membership)<tr><td><strong>{{ $membership->name }}</strong><small>{{ $membership->code }}</small></td><td>${{ number_format($membership->price, 2) }} MXN</td><td>{{ $membership->vacancy_limit ?? 'Ilimitadas' }}</td><td><span class="admin-badge {{ $membership->active ? '' : 'admin-badge--neutral' }}">{{ $membership->active ? 'Activa' : 'Inactiva' }}</span></td><td><a class="admin-link" href="{{ route('admin.memberships.edit', $membership->getKey()) }}">Editar</a>
@if($membership->active)<form method="POST" action="{{ route('admin.memberships.destroy', $membership->getKey()) }}">@csrf @method('DELETE')<button type="submit" class="admin-link">Desactivar</button></form>@endif</td></tr>
@empty<tr><td colspan="5" class="admin-empty">No hay membresías. Crea el primer plan.</td></tr>@endforelse
</tbody></table></div>@include('components.admin.pagination', ['records' => $memberships])
@endsection
