@extends('layouts.company-dashboard')

@section('dashboard-content')

<main
    class="company-applicant-profile"
    data-applicant-profile
    data-applications-url="{{ route('company.applications') }}"
>
    @include('components.flow-feedback')

    {{--  TITLE  --}}

    <h1 class="company-applicant-profile__title">
        Perfil de aplicante
    </h1>


    {{-- INFORMATION  --}}

    <div class="company-applicant-profile__content">

        @if($application['student']['avatar'])
            <img class="company-applicant-profile__avatar" src="{{ $application['student']['avatar'] }}" alt="Foto del estudiante">
        @endif


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

            <a href="{{ route('company.applications.cv', $application['id']) }}" class="company-applicant-profile__cv">

                <span>CV</span>

                <img
                    src="{{ asset('images/Download.svg') }}"
                    alt="Descargar CV"
                >

            </a>

        </div>

        @if($application['student']['description'])
            <section class="company-applicant-profile__about"><h2>Sobre el estudiante</h2><p>{{ $application['student']['description'] }}</p></section>
        @endif
        <p class="company-applicant-profile__status">Estado: {{ ['pending' => 'Pendiente', 'accepted' => 'Aceptada', 'rejected' => 'Rechazada'][$application['status']] ?? $application['status'] }}</p>
    </div>


    {{--  ACTIONS  --}}

    <div class="company-applicant-profile__actions">

        <form method="POST" action="{{ route('company.applications.status', $application['id']) }}">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="accepted">
            <button type="submit" class="company-applicant-profile__action company-applicant-profile__action--accept">Aceptar</button>
        </form>
        <form method="POST" action="{{ route('company.applications.status', $application['id']) }}">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="rejected">
            <button type="submit" class="company-applicant-profile__action company-applicant-profile__action--reject">Rechazar</button>
        </form>

    </div>

</main>

@endsection
