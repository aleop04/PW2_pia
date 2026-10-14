@extends('layouts.auth')

@section('title', 'Registrarse | NextStep')

@section('content')

@php
    $selectedType = old('_account_type', 'account-type');
    if (! in_array($selectedType, ['account-type', 'student', 'company'], true)) {
        $selectedType = 'account-type';
    }
@endphp

<main
    class="register-page"
    data-register-page
    data-initial-screen="{{ $selectedType }}"
>

    <div class="register-page__container">

        <!-- Logo -->
        <a
            href="{{ route('home') }}"
            class="register-page__logo-link"
        >
            <img
                src="{{ asset('images/logo.png') }}"
                alt="NextStep"
                class="register-page__logo"
            >
        </a>

        <a class="register-page__login-link" href="{{ route('login') }}">¿Ya tienes cuenta? Entrar</a>


        <!-- Flujo completo del registro -->
        <div class="register-flow">

            <!-- =========================================
                 ETAPA PRINCIPAL
                 Selector / estudiante / empresa + imagen; el pago pertenece a otro bloque
            ========================================== -->
            <div
                class="
                    register-flow__stage
                    register-flow__stage--main
                "
                data-register-main
            >

                <div class="register-page__content">

                    <!-- Lado izquierdo -->
                    <section class="register-page__left">

                        <!-- Selector de tipo de cuenta -->
                        <div
                            data-register-screen="account-type"
                            @if ($selectedType !== 'account-type') hidden @endif
                        >
                            @include('auth.register.account-type')
                        </div>


                        <!-- Registro estudiante -->
                        <div
                            data-register-screen="student"
                            @if ($selectedType !== 'student') hidden @endif
                        >
                            @include('auth.register.student-form')
                        </div>


                        <!-- Registro empresa -->
                        <div
                            data-register-screen="company"
                            @if ($selectedType !== 'company') hidden @endif
                        >
                            @include('auth.register.company-form')
                        </div>

                    </section>


                    <!-- Imagen fija -->
                    <div class="register-page__image-wrapper">

                        <img
                            src="{{ asset('images/register-image.png') }}"
                            alt="Registro"
                            class="register-page__image"
                        >

                    </div>

                </div>

            </div>

        </div>

    </div>

</main>

@endsection
