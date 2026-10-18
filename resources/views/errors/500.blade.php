@extends('layouts.auth')
@section('title', 'Ocurrió un problema | NextStep')
@section('content')
<x-error-page code="500" heading="Ocurrió un problema"
    message="No pudimos completar la operación en este momento. Vuelve a intentarlo más tarde."
    action-label="Volver al inicio" action-route="home" />
@endsection
