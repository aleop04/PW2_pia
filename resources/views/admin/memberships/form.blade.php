@extends('layouts.admin')
@section('title', $membership->exists ? 'Editar membresía' : 'Crear membresía')
@section('content')
<a class="admin-link" href="{{ route('admin.memberships.index') }}">← Membresías</a><h1>{{ $membership->exists ? 'Editar membresía' : 'Crear membresía' }}</h1><p class="admin-subtitle">Los cambios se reflejarán en el catálogo empresarial.</p>
<form method="POST" class="admin-form" action="{{ $membership->exists ? route('admin.memberships.update', $membership->getKey()) : route('admin.memberships.store') }}">@csrf @if($membership->exists) @method('PUT') @endif
<label>Nombre<input name="name" value="{{ old('name', $membership->name) }}" required maxlength="80"></label>
<label>Código único<input @if(!$membership->exists) name="code" @else disabled @endif value="{{ old('code', $membership->code) }}" pattern="[a-z][a-z0-9_-]*" maxlength="40" required><small>El código permanece fijo después de crear el plan.</small></label>
<label>Precio mensual (MXN)<input name="price" type="number" min="0" max="999999.99" step="0.01" value="{{ old('price', $membership->price) }}" required></label>
<label>Límite de vacantes<input name="vacancy_limit" type="number" min="0" max="100000" step="1" value="{{ old('vacancy_limit', $membership->vacancy_limit) }}" placeholder="Vacío = ilimitadas"></label>
<label>Prioridad<input name="priority" type="number" min="1" max="1000" step="1" value="{{ old('priority', $membership->priority ?? 1) }}" required></label>
<label>Estado<select name="active"><option value="1" @selected((string) old('active', (int) ($membership->active ?? true)) === '1')>Activa</option><option value="0" @selected((string) old('active', (int) ($membership->active ?? true)) === '0')>Inactiva</option></select></label>
<label class="admin-form__full">Beneficios (uno por línea)<textarea name="benefits_text" rows="5" required>{{ old('benefits_text', implode("\n", $membership->benefits ?? [])) }}</textarea></label>
<div class="admin-form__full admin-toolbar"><button class="admin-button admin-button--primary" type="submit">Guardar membresía</button><a class="admin-button" href="{{ route('admin.memberships.index') }}">Cancelar</a></div>
</form>
@endsection
