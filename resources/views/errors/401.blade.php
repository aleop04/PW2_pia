@extends('layouts.auth')
@section('title', 'Inicia sesión | NextStep')
@section('content')
<x-error-page code="401" heading="Necesitas iniciar sesión"
    message="Entra a tu cuenta para continuar con esta acción."
    action-label="Iniciar sesión" action-route="login" />
@endsection
