@extends('layouts.admin')
@section('title', 'Estudiantes')
@section('content')
<h1>Estudiantes</h1><p class="admin-subtitle">Consulta sus datos y documentos registrados.</p>
<div class="admin-summary">@foreach(['Estudiantes registrados', 'Documentación completa', 'Documentación pendiente'] as $index => $label)<div class="admin-stat"><strong>{{ $summary[$index] }}</strong><span>{{ $label }}</span></div>@endforeach</div>
<form method="GET" class="admin-toolbar"><label class="admin-search">Nombre, apellido o correo<input type="search" name="q" value="{{ request('q') }}" maxlength="100" placeholder="Buscar estudiante"></label><label>Documentos<select name="documents"><option value="">Todos</option><option value="complete" @selected(request('documents') === 'complete')>Completos</option><option value="missing" @selected(request('documents') === 'missing')>Pendientes</option></select></label><button class="admin-button" type="submit">Buscar</button><a class="admin-link" href="{{ route('admin.students.index') }}">Limpiar</a></form>
<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Estudiante</th><th>CV</th><th>Kárdex</th><th>Acciones</th></tr></thead><tbody>
@forelse($students as $student)
<tr><td><strong>{{ $student['name'] }}</strong><small>{{ $student['email'] }}</small></td>
<td>@if($student['cv_url'])<a class="admin-link" href="{{ $student['cv_url'] }}">Descargar CV</a>@else<span class="admin-badge admin-badge--neutral">Sin archivo</span>@endif</td>
<td>@if($student['kardex_url'])<a class="admin-link" href="{{ $student['kardex_url'] }}">Descargar kárdex</a>@else<span class="admin-badge admin-badge--neutral">Sin archivo</span>@endif</td>
<td><a class="admin-link" href="{{ route('admin.students.show', $student['id']) }}">Ver perfil</a></td></tr>
@empty<tr><td colspan="4" class="admin-empty">No hay estudiantes que coincidan con la búsqueda.</td></tr>@endforelse
</tbody></table></div>
@include('components.admin.pagination', ['records' => $students])
@endsection
