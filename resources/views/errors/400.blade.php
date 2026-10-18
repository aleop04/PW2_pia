@extends('layouts.auth')
@section('title', 'Solicitud incorrecta | NextStep')
@section('content')
<x-error-page code="400" heading="No pudimos procesar la solicitud"
    message="Revisa los datos enviados y vuelve a intentarlo desde la pantalla correspondiente."
    action-label="Volver al inicio" action-route="home" />
@endsection
