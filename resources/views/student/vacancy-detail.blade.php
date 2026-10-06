@extends('layouts.student')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | DATOS TEMPORALES
    |--------------------------------------------------------------------------
    |
    | Después la vacante vendrá de la base de datos usando el ID
    | de la URL.
    |
    */

    $vacancyId = request()->route('id');

    $companyIdByVacancy = [
        1 => 1,
        2 => 2,
    ];

    $companyId = $companyIdByVacancy[(int) $vacancyId] ?? 1;

    $vacancy = [
        'id' => $vacancyId,

        'companyId' => $companyId,

        'title' => 'Título de la vacante',
        'company' => 'Nombre de la empresa',

        'location' => 'Ubicación',

        'salary' => 'Sueldo',
        'modality' => 'Modalidad',

        'stayDuration' => 'Más de 4 semanas',

        'benefits' => [
            'Seguro dental',
            'Estacionamiento gratuito',
            'Uniformes gratuitos',
            'Caja de ahorro',
            'Descuento de gimnasio',
        ],

        'jobType' => 'Medio tiempo',

        'description' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit ullamcorper, volutpat mattis purus potenti eleifend venenatis facilisi, donec lacus faucibus nam nostra nibh eget. Duis habitasse justo nibh non dapibus risus hendrerit pulvinar, cubilia faucibus dictumst penatibus nunc sagittis litora, auctor nostra mattis in mi taciti turpis.

Scelerisque habitasse quis nulla tellus curae interdum inceptos ligula, eros natoque suspendisse mauris rhoncus euismod iaculis imperdiet platea, egestas vulputate hac placerat fermentum lobortis sem. Mollis rutrum maecenas quam ut nec viverra nam felis accumsan odio.',
    ];


    $student = [
        'firstName' => 'Nombre',
        'paternalSurname' => 'Apellido Paterno',
        'maternalSurname' => 'Apellido Materno',

        'email' => 'correo@gmail.com',
        'phone' => '1234567890',
        'location' => 'Ubicación',

        'cvName' => 'CV',
    ];


    $studentFullName = implode(
        ' ',
        array_filter([
            $student['firstName'],
            $student['paternalSurname'],
            $student['maternalSurname'],
        ])
    );

@endphp


<main
    class="vacancy-detail-page"
    data-student-vacancy-detail
    data-bookmark-icon="{{ asset('images/Bookmark.svg') }}"
    data-bookmark-filled-icon="{{ asset('images/BookmarkFilled.svg') }}"
>


    <x-vacancy-detail
        :vacancy="$vacancy"
        :company-href="route('student.companies.show', [
            'id' => $vacancy['companyId']
        ])"
    >

        <x-slot:actions>

            {{-- GUARDAR --}}

            <button
                type="button"
                class="vacancy-detail__bookmark"
                aria-label="Guardar vacante"
                data-detail-bookmark
            >

                <img
                    src="{{ asset('images/Bookmark.svg') }}"
                    alt=""
                    class="vacancy-detail__bookmark-icon"
                    data-detail-bookmark-icon
                >

            </button>


            {{-- POSTULARSE --}}

            <button
                type="button"
                class="vacancy-detail__primary-button"
                data-application-open
            >
                Postularse
            </button>

        </x-slot:actions>

    </x-vacancy-detail>


    {{--  MODAL DE REVISIÓN  --}}

    <x-review-modal title="Revisión de datos para postulación">

        <x-slot:description>

            <span>
                Estos son los datos que se enviarán a la empresa.
                Puedes modificarlos únicamente para esta postulación.
            </span>

        </x-slot:description>


        <form
            id="application-review-form"
            data-application-form
        >

            {{-- =====================================
                NOMBRE
            ====================================== --}}

            <div class="review-modal__field">

                <label
                    for="application-full-name"
                    class="review-modal__field-label"
                >
                    Nombre completo
                </label>

                <input
                    id="application-full-name"
                    type="text"
                    name="full_name"
                    class="review-modal__field-input"
                    value="{{ $studentFullName }}"
                    required
                >

            </div>


            {{-- =====================================
                CORREO
            ====================================== --}}

            <div class="review-modal__field">

                <label
                    for="application-email"
                    class="review-modal__field-label"
                >
                    Correo electrónico
                </label>

                <input
                    id="application-email"
                    type="email"
                    name="email"
                    class="review-modal__field-input"
                    value="{{ $student['email'] }}"
                    required
                >

            </div>


            {{-- =====================================
                TELÉFONO
            ====================================== --}}

            <div class="review-modal__field">

                <label
                    for="application-phone"
                    class="review-modal__field-label"
                >
                    Número telefónico
                </label>

                <input
                    id="application-phone"
                    type="tel"
                    name="phone"
                    class="review-modal__field-input"
                    value="{{ $student['phone'] }}"
                    required
                >

            </div>


            {{-- =====================================
                UBICACIÓN
            ====================================== --}}

            <div class="review-modal__field">

                <label
                    for="application-location"
                    class="review-modal__field-label"
                >
                    Ubicación
                </label>

                <input
                    id="application-location"
                    type="text"
                    name="location"
                    class="review-modal__field-input"
                    value="{{ $student['location'] }}"
                    required
                >

            </div>


            {{-- =====================================
                CV
            ====================================== --}}

            <div class="review-modal__field">

                <p class="review-modal__field-label">
                    CV
                </p>


                <label
                    for="application-cv"
                    class="review-modal__file"
                >

                    <span
                        class="review-modal__file-name"
                        data-cv-name
                    >
                        {{ $student['cvName'] }}
                    </span>

                    <span class="review-modal__file-action">
                        Cambiar archivo
                    </span>

                </label>


                <input
                    id="application-cv"
                    type="file"
                    name="cv"
                    accept=".pdf,application/pdf"
                    class="review-modal__file-input"
                    data-cv-input
                >


                <p
                    class="review-modal__file-message"
                    data-cv-message
                    hidden
                ></p>

            </div>

        </form>


        <x-slot:actions>

            <button
                type="submit"
                form="application-review-form"
                class="review-modal__primary-button"
                data-application-confirm
            >
                Enviar postulación
            </button>

        </x-slot:actions>

    </x-review-modal>

</main>

@endsection