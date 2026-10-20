@extends('layouts.company-dashboard')

@section('dashboard-content')

@php
    $vacancies = collect($applications)
        ->unique('vacancyId')
        ->values();
@endphp


<section
    class="company-applications"
    data-company-applications
>
    @include('components.flow-feedback')


    {{-- ENCABEZADO --}}
    <div class="company-applications__header">

        <h1 class="company-applications__title">
            Solicitudes recibidas
        </h1>


        {{-- FILTRO POR VACANTE --}}
        <div
            class="company-applications__filter"
            data-vacancy-filter
        >
            <div class="company-applications__dropdown">

                {{-- BOTÓN DEL FILTRO --}}
                <button
                    type="button"
                    class="company-applications__filter-trigger"
                    data-vacancy-trigger
                    aria-expanded="false"
                >
                    <span data-vacancy-trigger-text>
                        Todas las vacantes
                    </span>

                    <span
                        class="company-applications__filter-arrow"
                        aria-hidden="true"
                    ></span>
                </button>


                {{-- OPCIONES --}}
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


    {{-- SOLICITUDES --}}
    <div
        class="company-applications__grid"
        data-applications-grid
    >

        @forelse ($applications as $application)

            @include(
                'components.company.applicant-card',
                ['application' => $application]
            )

        @empty

            <p class="company-applications__empty">
                Aún no recibes postulaciones.
            </p>

        @endforelse

    </div>


    {{-- SIN RESULTADOS DEL FILTRO --}}
    <p
        class="company-applications__empty"
        data-applications-empty
        hidden
    >
        No hay solicitudes para esta vacante.
    </p>

</section>

@endsection