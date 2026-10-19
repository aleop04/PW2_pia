@extends('layouts.auth')
@section('title', 'Servicio no disponible | NextStep')
@section('content')
<x-error-page code="503" heading="Servicio temporalmente no disponible"
    message="No fue posible completar la operación con la base de datos. Inténtalo de nuevo más tarde."
    action-label="Volver al inicio" action-route="home" />
@endsection
