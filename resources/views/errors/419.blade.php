@extends('layouts.auth')
@section('title', 'Formulario vencido | NextStep')
@section('content')
<x-error-page code="419" heading="El formulario ha vencido"
    message="Vuelve a abrir la pantalla e inténtalo de nuevo."
    action-label="Abrir de nuevo" :action-route="request()->is('registro/*') ? 'register' : 'login'" />
@endsection
