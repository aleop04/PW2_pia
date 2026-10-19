@extends('layouts.auth')
@section('title', 'Página no encontrada | NextStep')
@section('content')
<x-error-page code="404" heading="No encontramos esta página"
    message="Puede que la dirección haya cambiado o que la vacante ya no esté disponible."
    action-label="Volver al inicio" action-route="home" />
@endsection
