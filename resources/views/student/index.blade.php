@extends('layouts.student')

@section('content')

@php
    $salaryOptions = [
        5000,
        10000,
        15000,
        20000,
        25000,
        30000,
        40000,
        50000,
    ];

@endphp


<main
    class="student-home"
    data-student-home
    data-vacancy-detail-url="{{ route('student.vacancies.show', ['id' => '__ID__']) }}"
    data-company-profile-url="{{ route('student.companies.show', ['id' => '__ID__']) }}"
    data-application-url="{{ route('student.applications.store', ['id' => '__ID__']) }}"
    data-initial-vacancy-id="{{ old('vacancy_id') }}"
    data-open-on-error="{{ $errors->any() ? 'true' : 'false' }}"
>

    {{-- Datos temporales para JavaScript --}}

    <script
        type="application/json"
        data-vacancies-json
    >@json($vacancies)</script>


    {{--  BUSCADOR DE VACANTES  --}}

    <form
        class="vacancy-search"
        data-vacancy-search
    >

        {{--  BARRA PRINCIPAL  --}}

        <div class="vacancy-search__main">

            <div class="vacancy-search__fields">

                {{-- TÍTULO / EMPRESA --}}

                <div class="vacancy-search__field">

                    <img
                        src="{{ asset('images/Search.svg') }}"
                        alt=""
                        class="vacancy-search__field-icon"
                    >

                    <input
                        type="text"
                        name="query"
                        class="vacancy-search__input"
                        placeholder="Título de puesto, empresa"
                    >

                </div>


                {{-- SEPARADOR --}}

                <div class="vacancy-search__separator"></div>


                {{-- UBICACIÓN --}}

                <div class="
                    vacancy-search__field
                    vacancy-search__field--location
                ">

                    <img
                        src="{{ asset('images/Mappin.svg') }}"
                        alt=""
                        class="vacancy-search__field-icon"
                    >

                    <input
                        type="text"
                        name="location"
                        class="vacancy-search__input"
                        placeholder="Ubicación"
                    >

                </div>

            </div>


            {{-- BUSCAR --}}

            <button
                type="submit"
                class="vacancy-search__button"
            >
                Buscar vacantes
            </button>

        </div>


        {{--  MOSTRAR BÚSQUEDA AVANZADA  --}}

        <button
            type="button"
            class="vacancy-search__advanced-toggle"
            aria-expanded="false"
            aria-label="Mostrar búsqueda avanzada"
            data-advanced-toggle
        >

            <img
                src="{{ asset('images/Chevrondown.svg') }}"
                alt=""
                class="vacancy-search__advanced-icon"
                data-advanced-icon
            >

        </button>


        {{--  BÚSQUEDA AVANZADA  --}}

        <div
            class="vacancy-search__advanced"
            data-advanced-panel
            hidden
        >

            {{-- FECHA + SUELDO --}}

            <div class="vacancy-search__advanced-row">


                {{--  FECHA DE PUBLICACIÓN  --}}

                <div class="
                    vacancy-search__advanced-group
                    vacancy-search__publication
                ">

                    <h3 class="vacancy-search__advanced-title">
                        Fecha de publicación
                    </h3>

                    <div class="vacancy-search__publication-select-wrapper">

                        <select
                            name="publication_age"
                            class="vacancy-search__publication-select"
                        >

                            <option value="">
                                Cualquier fecha
                            </option>

                            <option value="7">
                                Última semana
                            </option>

                            <option value="14">
                                Últimas 2 semanas
                            </option>

                            <option value="21">
                                Últimas 3 semanas
                            </option>

                            <option value="older_21">
                                Hace más de 3 semanas
                            </option>

                        </select>

                        <img
                            src="{{ asset('images/Chevrondown.svg') }}"
                            alt=""
                            class="vacancy-search__publication-select-icon"
                        >

                    </div>

                </div>


                {{--  RANGO DE SUELDO  --}}

                <div class="
                    vacancy-search__advanced-group
                    vacancy-search__salary
                ">

                    <h3 class="vacancy-search__advanced-title">
                        Rango de sueldo
                    </h3>


                    <div class="vacancy-search__advanced-controls">

                        {{-- MÍNIMO --}}

                        <div class="vacancy-search__select-wrapper">

                            <select
                                name="min_salary"
                                class="vacancy-search__select"
                            >

                                <option value="">
                                    $$$
                                </option>

                                @foreach ($salaryOptions as $salary)

                                    <option value="{{ $salary }}">
                                        ${{ number_format($salary) }}
                                    </option>

                                @endforeach

                            </select>

                            <img
                                src="{{ asset('images/Chevrondown.svg') }}"
                                alt=""
                                class="vacancy-search__select-icon"
                            >

                        </div>


                        {{-- MÁXIMO --}}

                        <div class="vacancy-search__select-wrapper">

                            <select
                                name="max_salary"
                                class="vacancy-search__select"
                            >

                                <option value="">
                                    $$$
                                </option>

                                @foreach ($salaryOptions as $salary)

                                    <option value="{{ $salary }}">
                                        ${{ number_format($salary) }}
                                    </option>

                                @endforeach

                            </select>

                            <img
                                src="{{ asset('images/Chevrondown.svg') }}"
                                alt=""
                                class="vacancy-search__select-icon"
                            >

                        </div>

                    </div>

                </div>

            </div>


            {{--  SECTOR  --}}

            <div class="
                vacancy-search__advanced-group
                vacancy-search__sector
            ">

                <h3 class="vacancy-search__advanced-title">
                    Sector
                </h3>


                <div class="vacancy-search__sector-dropdown">

                    <input
                        type="hidden"
                        name="sector"
                        data-sector-input
                    >


                    {{-- CAJA CERRADA --}}

                    <button
                        type="button"
                        class="vacancy-search__sector-trigger"
                        data-sector-trigger
                    >

                        <span
                            class="
                                vacancy-search__sector-text
                                vacancy-search__sector-placeholder
                            "
                            data-sector-label
                        >
                            Sector
                        </span>

                        <img
                            src="{{ asset('images/Chevrondown.svg') }}"
                            alt=""
                            class="vacancy-search__sector-icon"
                            data-sector-icon
                        >

                    </button>


                    {{-- CAJA DESPLEGABLE --}}

                    <div
                        class="vacancy-search__sector-menu"
                        data-sector-menu
                        hidden
                    ></div>

                </div>

            </div>

        </div>

    </form>


    {{--  VACANTES  --}}

    <section class="student-home__vacancy-area">


        {{--  LISTADO IZQUIERDO  --}}

        <div class="student-home__vacancy-list-section">

            <h2 class="student-home__vacancy-list-title">
                Vacantes para ti
            </h2>


            <div class="student-home__vacancy-list">

                @forelse ($vacancies as $vacancy)

                    <x-vacancy-card
                        :vacancy="$vacancy"
                        variant="home"
                    />

                @empty
                    <p>Aún no hay vacantes publicadas. Cuando una empresa publique una, aparecerá aquí.</p>
                @endforelse

            </div>

        </div>


        {{--  VISTA PREVIA DERECHA  --}}

        @if($vacancies->isNotEmpty())
            <x-student.vacancy-preview :vacancy="$vacancies->first()" />
        @endif

    </section>

    @if($vacancies->isNotEmpty())
        @include('student.partials.application-modal', ['vacancy' => $vacancies->first(), 'student' => auth('web')->user()])
    @endif

</main>

@endsection
