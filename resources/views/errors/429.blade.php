@extends('layouts.auth')
@section('title', 'Espera un momento | NextStep')
@section('content')
<x-error-page code="429" heading="Espera un momento"
    message="Se realizaron demasiados intentos. Espera un minuto y vuelve a intentarlo."
    action-label="Volver" :action-route="request()->is('registro/*') ? 'register' : 'login'" />
@endsection
