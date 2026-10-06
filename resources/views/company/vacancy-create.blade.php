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
    data-vacancy-create
    data-vacancies-url="{{ route('company.vacancies.index') }}"
>

    <form
        class="company-vacancy-form"
        data-vacancy-form
    >

        {{-- TITULO --}}

        <h1 class="company-vacancy-form__title">
            Publicar una vacante
        </h1>


        {{--  CONTENIDO PRINCIPAL  --}}

        <div class="company-vacancy-form__main">


            {{--  COLUMNA IZQUIERDA  --}}

            <div class="company-vacancy-form__fields">


                {{--  TÍTULO DEL PUESTO  --}}

                <div class="company-vacancy-form__field">

                    <label for="vacancy-title">
                        Título del puesto
                    </label>

                    <input
                        id="vacancy-title"
                        name="title"
                        type="text"
                        class="company-vacancy-form__input"
                        required
                    >

                </div>


                {{--  MODALIDAD  --}}

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

                        <option value="Remoto">
                            Remoto
                        </option>

                        <option value="Presencial">
                            Presencial
                        </option>

                        <option value="Híbrido">
                            Híbrido
                        </option>

                    </select>

                </div>


                {{--  UBICACIÓN  --}}

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
                            required
                        >

                        <img
                            src="{{ asset('images/Mappin.svg') }}"
                            alt=""
                            class="company-vacancy-form__location-icon"
                        >

                    </div>

                </div>


                {{--  TIEMPO DE CONTRATACIÓN  --}}

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

                        <option value="3 meses">
                            3 meses
                        </option>

                        <option value="6 meses">
                            6 meses
                        </option>

                    </select>

                </div>


                {{--  SALARIO  --}}

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
                                min="0"
                                class="company-vacancy-form__input"
                                data-salary-fixed
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
                            >

                                <option value="Por mes">
                                    Por mes
                                </option>

                                <option value="Por quincena">
                                    Por quincena
                                </option>

                                <option value="Por semana">
                                    Por semana
                                </option>

                            </select>

                        </div>

                    </div>

                </section>

            </div>


            {{--  COLUMNA DERECHA DESCRIPCIÓN  --}}

            <div class="company-vacancy-form__description">

                <label for="vacancy-description">
                    Descripción del puesto
                </label>

                <textarea
                    id="vacancy-description"
                    name="description"
                    required
                ></textarea>

            </div>

        </div>


        {{--  PRESTACIONES  --}}

        <section class="company-vacancy-form__benefits">

            <h2>
                Prestaciones <span class="company-vacancy-form__required">*</span>
            </h2>

            <div class="company-vacancy-form__benefit-list">

                @foreach ($benefitOptions as $benefit)

                    <button
                        type="button"
                        class="company-vacancy-form__benefit"
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
                        >

                    </button>

                @endforeach

            </div>

        </section>


        {{--  ACCIÓN  --}}

        <div class="company-vacancy-form__actions">

            <button
                type="submit"
                class="
                    company-vacancy-form__action-button
                    company-vacancy-form__action-button--publish
                "
            >
                Publicar
            </button>

        </div>

    </form>


    {{--  MODAL DE REVISIÓN  --}}

    <div
        class="vacancy-review-modal"
        data-review-modal
        hidden
    >

        <div class="vacancy-review-modal__overlay"></div>


        <div class="vacancy-review-modal__dialog">

            <h2 class="vacancy-review-modal__title">
                Revisión de datos para vacante
            </h2>

            <p class="vacancy-review__intro">
                Asegúrate de que la información que proporcionaste
                sea correcta y fiable.
            </p>


            <div class="vacancy-review">


                {{--  TÍTULO  --}}

                <div class="vacancy-review__field">

                    <span class="vacancy-review__label">
                        Título del puesto
                    </span>

                    <div
                        class="vacancy-review__value"
                        data-review-title
                    ></div>

                </div>


                {{--  MODALIDAD  --}}

                <div class="vacancy-review__field">

                    <span class="vacancy-review__label">
                        Modalidad de empleo
                    </span>

                    <div
                        class="vacancy-review__value"
                        data-review-modality
                    ></div>

                </div>


                {{--   UBICACIÓN  --}}

                <div class="vacancy-review__field">

                    <span class="vacancy-review__label">
                        Ubicación de empleo
                    </span>

                    <div
                        class="vacancy-review__value"
                        data-review-location
                    ></div>

                </div>


                {{--  DURACIÓN  --}}

                <div class="vacancy-review__field">

                    <span class="vacancy-review__label">
                        Tiempo de contratación
                    </span>

                    <div
                        class="vacancy-review__value"
                        data-review-duration
                    ></div>

                </div>


                {{--  SALARIO  --}}

                <div class="vacancy-review__field">

                    <span class="vacancy-review__label">
                        Salario
                    </span>

                    <div
                        class="vacancy-review__value"
                        data-review-salary
                    ></div>

                </div>


                {{--  DESCRIPCIÓN  --}}

                <div class="vacancy-review__field">

                    <span class="vacancy-review__label">
                        Descripción del puesto
                    </span>

                    <div
                        class="
                            vacancy-review__value
                            vacancy-review__value--description
                        "
                        data-review-description
                    ></div>

                </div>


                {{--  PRESTACIONES  --}}

                <div class="vacancy-review__field">

                    <span class="vacancy-review__label">
                        Prestaciones
                    </span>

                    <div
                        class="vacancy-review__benefits"
                        data-review-benefits
                    ></div>

                </div>

            </div>


            {{--  ACCIONES DEL MODAL  --}}

            <div class="vacancy-review-modal__actions">

                <button
                    type="button"
                    class="
                        vacancy-review__button
                        vacancy-review__button--cancel
                    "
                    data-review-cancel
                >
                    Cancelar
                </button>

                <button
                    type="button"
                    class="
                        vacancy-review__button
                        vacancy-review__button--confirm
                    "
                    data-review-confirm
                >
                    Confirmar
                </button>

            </div>

        </div>

    </div>

</main>

@endsection