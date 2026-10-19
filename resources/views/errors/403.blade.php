@extends('layouts.auth')
@section('title', 'Acceso no permitido | NextStep')
@section('content')
@php
    $destination = match (auth('web')->user()?->role) {
        'student' => 'student.home',
        'company' => 'company.home',
        default => 'home',
    };
@endphp
<x-error-page code="403" heading="Acceso no permitido"
    message="Esta sección pertenece a otro tipo de cuenta."
    action-label="Volver a mi inicio" :action-route="$destination" />
@endsection
