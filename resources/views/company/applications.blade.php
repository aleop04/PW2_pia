@extends('layouts.company-dashboard')

@section('dashboard-content')

@php

    /*
    |--------------------------------------------------------------------------
    | SOLICITUDES TEMPORALES
    |--------------------------------------------------------------------------
    |
    | Después vendrán de la base de datos.
    |
    */

    $applications = [

        [
            'id' => 1,
            'studentId' => 1,
            'name' => 'Nombre de aplicante',
            'vacancyId' => 1,
            'vacancyTitle' => 'Desarrollador Frontend',
        ],

        [
            'id' => 2,
            'studentId' => 2,
            'name' => 'Nombre de aplicante',
            'vacancyId' => 1,
            'vacancyTitle' => 'Desarrollador Frontend',
        ],

        [
            'id' => 3,
            'studentId' => 3,
            'name' => 'Nombre de aplicante',
            'vacancyId' => 2,
            'vacancyTitle' => 'Diseñador UX/UI',
        ],

        [
            'id' => 4,
            'studentId' => 4,
            'name' => 'Nombre de aplicante',
            'vacancyId' => 2,
            'vacancyTitle' => 'Diseñador UX/UI',
        ],

        [
            'id' => 5,
            'studentId' => 5,
            'name' => 'Nombre de aplicante',
            'vacancyId' => 3,
            'vacancyTitle' => 'Analista de datos',
        ],

        [
            'id' => 6,
            'studentId' => 6,
            'name' => 'Nombre de aplicante',
            'vacancyId' => 3,
            'vacancyTitle' => 'Analista de datos',
        ],

    ];


    /*
    |--------------------------------------------------------------------------
    | VACANTES PARA EL FILTRO
    |--------------------------------------------------------------------------
    */

    $vacancies = collect($applications)
        ->unique('vacancyId')
        ->values();

@endphp


<section
    class="company-applications"
    data-company-applications
>

    <div class="company-applications__header">

        <h1 class="company-applications__title">
            Solicitudes recibidas
        </h1>


        {{-- FILTRO --}}

        <div
            class="company-applications__filter"
            data-vacancy-filter
        >
            <div class="company-applications__dropdown">

                <button
                    type="button"
                    class="company-applications__filter-trigger"
                    data-vacancy-trigger
                    aria-expanded="false"
                >

                    <span data-vacancy-trigger-text>
                        Todas las vacantes
                    </span>

                    <span class="company-applications__filter-arrow">
                    </span>

                </button>


                <div
                    class="company-applications__filter-menu"
                    data-vacancy-menu
                    hidden
                >

                    <button
                        type="button"
                        class="
                            company-applications__filter-option
                            company-applications__filter-option--active
                        "
                        data-vacancy-option
                        data-vacancy-id="all"
                    >
                        Todas las vacantes
                    </button>


                    @foreach ($vacancies as $vacancy)

                        <button
                            type="button"
                            class="company-applications__filter-option"
                            data-vacancy-option
                            data-vacancy-id="{{ $vacancy['vacancyId'] }}"
                        >
                            {{ $vacancy['vacancyTitle'] }}
                        </button>

                    @endforeach

                </div>

            </div>

        </div>

    </div>


    <div
        class="company-applications__grid"
        data-applications-grid
    >

        @foreach ($applications as $application)

            @include(
                'components.company.applicant-card',
                ['application' => $application]
            )

        @endforeach

    </div>


    <p
        class="company-applications__empty"
        data-applications-empty
        hidden
    >
        No hay solicitudes para esta vacante.
    </p>

</section>

@endsection