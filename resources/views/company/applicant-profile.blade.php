@extends('layouts.company-dashboard')

@section('dashboard-content')

@php

    /*
    |--------------------------------------------------------------------------
    | DATOS TEMPORALES
    |--------------------------------------------------------------------------
    |
    | Después la solicitud y el estudiante vendrán de la base de datos
    | utilizando el ID de la ruta.
    |
    */

    $applicationId = request()->route('id');

    $application = [

        'id' => $applicationId,

        'student' => [
            'id' => 1,
            'fullName' => 'Nombre completo',
            'email' => 'correo@ejemplo.com',
            'location' => 'Ciudad, Estado',
            'phone' => '1234567890',
            'birthDate' => '01/01/2000',
            'cv' => 'CV.pdf',
        ],

    ];

@endphp


<main
    class="company-applicant-profile"
    data-applicant-profile
    data-applications-url="{{ route('company.applications') }}"
>

    {{--  TITLE  --}}

    <h1 class="company-applicant-profile__title">
        Perfil de aplicante
    </h1>


    {{-- INFORMATION  --}}

    <div class="company-applicant-profile__content">


        {{-- NOMBRE --}}

        <div class="company-applicant-profile__field">

            <span class="company-applicant-profile__label">
                Nombre completo
            </span>

            <div class="company-applicant-profile__value">
                {{ $application['student']['fullName'] }}
            </div>

        </div>


        {{-- EMAIL --}}

        <div class="company-applicant-profile__field">

            <span class="company-applicant-profile__label">
                Correo electrónico
            </span>

            <div class="company-applicant-profile__value">
                {{ $application['student']['email'] }}
            </div>

        </div>


        {{-- UBICACIÓN --}}

        <div class="company-applicant-profile__field">

            <span class="company-applicant-profile__label">
                Ubicación
            </span>

            <div class="company-applicant-profile__value">
                {{ $application['student']['location'] }}
            </div>

        </div>


        {{-- NÚMERO + FECHA --}}

        <div class="company-applicant-profile__row">

            <div
                class="
                    company-applicant-profile__field
                    company-applicant-profile__field--half
                "
            >

                <span class="company-applicant-profile__label">
                    Número
                </span>

                <div class="company-applicant-profile__value">
                    {{ $application['student']['phone'] }}
                </div>

            </div>


            <div
                class="
                    company-applicant-profile__field
                    company-applicant-profile__field--half
                "
            >

                <span class="company-applicant-profile__label">
                    Fecha de nacimiento
                </span>

                <div class="company-applicant-profile__value">
                    {{ $application['student']['birthDate'] }}
                </div>

            </div>

        </div>


        {{-- CV --}}

        <div
            class="
                company-applicant-profile__field
                company-applicant-profile__field--cv
            "
        >

            <span class="company-applicant-profile__label">
                CV
            </span>

            <button
                type="button"
                class="company-applicant-profile__cv"
                data-download-cv
                data-cv="{{ $application['student']['cv'] }}"
            >

                <span>CV</span>

                <img
                    src="{{ asset('images/Download.svg') }}"
                    alt="Descargar CV"
                >

            </button>

        </div>

    </div>


    {{--  ACTIONS  --}}

    <div class="company-applicant-profile__actions">

        <button
            type="button"
            class="
                company-applicant-profile__action
                company-applicant-profile__action--accept
            "
            data-accept-application
        >
            Aceptar
        </button>


        <button
            type="button"
            class="
                company-applicant-profile__action
                company-applicant-profile__action--reject
            "
            data-reject-application
        >
            Rechazar
        </button>

    </div>

</main>

@endsection