@extends('layouts.company')

@section('content')

@php

    $benefitOptions = [
        'Seguro dental',
        'Estacionamiento de la empresa',
        'Horarios flexibles',
        'Estacionamiento gratuito',
        'Uniformes gratuitos',
        'Bebidas gratis',
        'Opción a contrato indefinido',
        'Días por enfermedad',
        'Descuento de empleados',
        'Programa de referidos',
        'Ayuda o servicio de transporte',
        'Servicio de comedor',
        'Automóvil de la empresa',
        'Trabajo desde casa',
        'Seguro de vida',
        'Seguro de gastos médicos',
        'Seguro de la vista',
        'Días de maternidad superiores a los de la ley',
        'Vales de despensa',
        'Descuento de gimnasio',
        'Apoyo al desarrollo profesional',
        'Días de paternidad superiores a los de la ley',
        'Seguro de gastos médicos mayores',
        'Servicio de gimnasio',
        'Servicio de comedor con descuento',
        'Vacaciones adicionales o permisos con goce de sueldo',
        'Teléfono de la empresa',
        'Vales de restaurante',
        'Caja de ahorro',
        'Documentos y precios preferenciales',
        'Aumentos salariales',
    ];

@endphp


<main
    class="company-vacancy-create"
    data-vacancy-edit
    data-vacancy-id="{{ $vacancy['id'] }}"
    data-vacancy-detail-url="{{ route(
        'company.vacancies.show',
        ['id' => $vacancy['id']]
    ) }}"
>
    @include('components.flow-feedback')

    <form
        class="company-vacancy-form"
        data-vacancy-edit-form
        method="POST"
        action="{{ route('company.vacancies.update', $vacancy['id']) }}"
    >
        @csrf
        @method('PUT')

        {{--  TITLE  --}}

        <h1 class="company-vacancy-form__title">
            Editar la información de la vacante
        </h1>


        {{--  MAIN CONTENT  --}}

        <div class="company-vacancy-form__main">


            {{--  LEFT COLUMN  --}}

            <div class="company-vacancy-form__fields">


                {{-- TÍTULO --}}

                <div class="company-vacancy-form__field">

                    <label for="vacancy-title">
                        Título del puesto
                    </label>

                    <input
                        id="vacancy-title"
                        name="title"
                        type="text"
                        class="company-vacancy-form__input"
                        value="{{ $vacancy['title'] }}"
                        required
                    >

                </div>


                {{-- MODALIDAD --}}

                <div class="company-vacancy-form__field">

                    <label for="vacancy-modality">
                        Modalidad de empleo
                    </label>

                    <select
                        id="vacancy-modality"
                        name="modality"
                        class="company-vacancy-form__input"
                        required
                    >

                        <option
                            value="Remoto"
                            @selected($vacancy['modality'] === 'Remoto')
                        >
                            Remoto
                        </option>

                        <option
                            value="Presencial"
                            @selected($vacancy['modality'] === 'Presencial')
                        >
                            Presencial
                        </option>

                        <option
                            value="Híbrido"
                            @selected($vacancy['modality'] === 'Híbrido')
                        >
                            Híbrido
                        </option>

                    </select>

                </div>


                {{-- UBICACIÓN --}}

                <div class="company-vacancy-form__field">

                    <label for="vacancy-location">
                        Ubicación del empleo
                    </label>

                    <div class="company-vacancy-form__input-icon-wrapper">

                        <input
                            id="vacancy-location"
                            name="location"
                            type="text"
                            class="company-vacancy-form__input"
                            value="{{ $vacancy['location'] }}"
                            required
                        >

                        <img
                            src="{{ asset('images/Mappin.svg') }}"
                            alt=""
                            class="company-vacancy-form__location-icon"
                        >

                    </div>

                </div>


                {{-- TIEMPO DE CONTRATACIÓN --}}

                <div class="company-vacancy-form__field">

                    <label for="vacancy-duration">
                        Tiempo de contratación
                    </label>

                    <select
                        id="vacancy-duration"
                        name="stay_duration"
                        class="company-vacancy-form__input"
                        required
                    >

                        <option
                            value="3 meses"
                            @selected($vacancy['stayDuration'] === '3 meses')
                        >
                            3 meses
                        </option>

                        <option
                            value="6 meses"
                            @selected($vacancy['stayDuration'] === '6 meses')
                        >
                            6 meses
                        </option>

                    </select>

                </div>


                {{--   SALARIO  --}}

                <section class="company-vacancy-form__salary">

                    <h2>
                        Salario
                    </h2>

                    <div class="company-vacancy-form__salary-fields">


                        {{-- SUELDO --}}

                        <div class="company-vacancy-form__field">

                            <label for="salary-fixed">
                                Sueldo
                            </label>

                            <input
                                id="salary-fixed"
                                name="salary_fixed"
                                type="number"
                                min="1"
                                class="company-vacancy-form__input"
                                value="{{ $vacancy['salaryFixed'] }}"
                                required
                            >

                        </div>


                        {{-- PERIODICIDAD --}}

                        <div class="company-vacancy-form__field">

                            <label for="salary-periodicity">
                                Periodicidad
                            </label>

                            <select
                                id="salary-periodicity"
                                name="periodicity"
                                class="company-vacancy-form__input"
                                required
                            >

                                <option
                                    value="Por mes"
                                    @selected($vacancy['periodicity'] === 'Por mes')
                                >
                                    Por mes
                                </option>

                                <option
                                    value="Por quincena"
                                    @selected($vacancy['periodicity'] === 'Por quincena')
                                >
                                    Por quincena
                                </option>

                                <option
                                    value="Por semana"
                                    @selected($vacancy['periodicity'] === 'Por semana')
                                >
                                    Por semana
                                </option>

                            </select>

                        </div>

                    </div>

                </section>

            </div>


            {{--   DESCRIPTION  --}}

            <div class="company-vacancy-form__description">

                <label for="vacancy-description">
                    Descripción del puesto
                </label>

                <textarea
                    id="vacancy-description"
                    name="description"
                    required
                >{{ $vacancy['description'] }}</textarea>

            </div>

        </div>


        {{--  BENEFITS  --}}

        <section class="company-vacancy-form__benefits">
            <p class="flow-feedback flow-feedback--error" data-benefits-error hidden>Selecciona al menos una prestación.</p>

            <h2>
                Prestaciones
                <span class="company-vacancy-form__required">*</span>
            </h2>


            <div class="company-vacancy-form__benefit-list">

                @foreach ($benefitOptions as $benefit)

                    @php
                        $isSelected = in_array(
                            $benefit,
                            $vacancy['benefits'],
                            true
                        );
                    @endphp


                    <button
                        type="button"
                        class="
                            company-vacancy-form__benefit
                            {{ $isSelected
                                ? 'company-vacancy-form__benefit--selected'
                                : ''
                            }}
                        "
                        data-benefit
                        data-benefit-value="{{ $benefit }}"
                    >

                        <span>
                            {{ $benefit }}
                        </span>


                        <img
                            src="{{ asset('images/Pluscircle.svg') }}"
                            alt=""
                            data-benefit-icon
                            class="
                                {{ $isSelected
                                    ? 'company-vacancy-form__benefit-icon--selected'
                                    : ''
                                }}
                            "
                        >

                    </button>

                @endforeach

            </div>

        </section>


        {{--  ACTIONS  --}}

        <div class="company-vacancy-form__actions">

            <a
                href="{{ route(
                    'company.vacancies.show',
                    ['id' => $vacancy['id']]
                ) }}"
                class="
                    company-vacancy-form__action-button
                    company-vacancy-form__action-button--cancel
                "
            >
                Cancelar cambios
            </a>


            <button
                type="submit"
                class="
                    company-vacancy-form__action-button
                    company-vacancy-form__action-button--confirm
                "
            >
                Confirmar cambios
            </button>

        </div>

    </form>

</main>

@endsection
