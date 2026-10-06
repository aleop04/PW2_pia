@extends('layouts.auth')

@section('title', 'Registrarse | NextStep')

@section('content')

<main
    class="register-page"
    data-register-page
    data-student-url="{{ route('student.home') }}"
    data-company-url="{{ route('company.home') }}"
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


        <!-- Flujo completo del registro -->
        <div class="register-flow">

            <!-- =========================================
                 ETAPA PRINCIPAL
                 Selector / estudiante / empresa + imagen
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
                        >
                            @include('auth.register.account-type')
                        </div>


                        <!-- Registro estudiante -->
                        <div
                            data-register-screen="student"
                            hidden
                        >
                            @include('auth.register.student-form')
                        </div>


                        <!-- Registro empresa -->
                        <div
                            data-register-screen="company"
                            hidden
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


            <!-- =========================================
                 ETAPA MEMBRESÍA + PAGO
            ========================================== -->
            <div
                class="
                    register-flow__stage
                    register-flow__stage--membership
                "
                data-register-membership
            >

                @include('auth.register.company-membership')

            </div>

        </div>

    </div>

</main>

@endsection