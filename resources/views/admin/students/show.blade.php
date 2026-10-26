@extends('layouts.admin')
@section('title', 'Perfil del estudiante')
@section('content')
<a class="admin-link" href="{{ route('admin.students.index') }}">← Estudiantes</a><h1>{{ $student['name'] }}</h1><p class="admin-subtitle">Información registrada en su perfil.</p>
<dl class="admin-details"><div><dt>Correo</dt><dd>{{ $student['email'] }}</dd></div><div><dt>Teléfono</dt><dd>{{ $student['phone'] ?: 'Sin registrar' }}</dd></div><div><dt>Fecha de nacimiento</dt><dd>{{ $student['birth_date'] ?: 'Sin registrar' }}</dd></div><div><dt>Postulaciones realizadas</dt><dd>{{ $student['application_count'] }}</dd></div></dl>
<div class="admin-toolbar">@foreach(['cv_url' => 'CV', 'kardex_url' => 'Kárdex'] as $key => $label) @if($student[$key])<a class="admin-button" href="{{ $student[$key] }}">Descargar {{ $label }}</a>@else<span>{{ $label }}: sin archivo</span>@endif @endforeach</div>
@endsection
