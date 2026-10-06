@extends('layouts.student')

@section('content')

@php

    $companyId = request()->route('id');

    $company = [
    'id' => $companyId,
    'name' => 'Nombre de empresa',
    'logo' => null,
    'rating' => 5.0,

    'description' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit ullamcorper, volutpat mattis purus potenti eleifend venenatis facilisi, donec lacus faucibus nam nostra nibh eget. Duis habitasse justo nibh non dapibus risus hendrerit pulvinar, cubilia faucibus dictumst penatibus nunc sagittis litora.

Scelerisque habitasse quis nulla tellus curae interdum inceptos ligula, eros natoque suspendisse mauris rhoncus euismod iaculis imperdiet platea.',

    'sector' => 'Marketing',
];


    $vacancies = [
        [
            'id' => 1,
            'title' => 'Título de la vacante',
            'company' => 'Nombre de empresa',
            'location' => 'Ubicación',
            'salary' => 'Sueldo',
            'modality' => 'Modalidad',

            'benefits' => [
                'Seguro dental',
                'Caja de ahorro',
                'Gimnasio',
                'Uniformes',
            ],
        ],

        [
            'id' => 2,
            'title' => 'Segunda vacante',
            'company' => 'Nombre de empresa',
            'location' => 'Monterrey',
            'salary' => '$18,000',
            'modality' => 'Híbrido',

            'benefits' => [
                'Seguro dental',
                'Caja de ahorro',
            ],
        ],
    ];


    $reviews = [
        [
            'id' => 1,
            'rating' => 5,
            'date' => '2026-09-08',

            'position' => 'Puesto',
            'duration' => 'Duración de puesto',

            'comment' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit ullamcorper, volutpat mattis purus potenti eleifend venenatis facilisi.',
        ],

        [
            'id' => 2,
            'rating' => 1,
            'date' => '2026-08-15',

            'position' => 'Puesto',
            'duration' => null,

            'comment' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit ullamcorper.',
        ],
    ];

@endphp


<main
    class="company-public-profile"
    data-company-public-profile
>

    <script
        type="application/json"
        data-reviews-json
    >@json($reviews)</script>


    {{-- PARTE SUPERIOR --}}

    <section class="company-public-profile__top">

        <div class="company-public-profile__header">

            <div class="company-public-profile__identity">

                @if ($company['logo'])

                    <img
                        src="{{ $company['logo'] }}"
                        alt="Logo de {{ $company['name'] }}"
                        class="company-public-profile__logo"
                    >

                @else

                    <div class="
                        company-public-profile__logo
                        company-public-profile__logo--empty
                    "></div>

                @endif


                <div class="company-public-profile__identity-info">

                    <h1 class="company-public-profile__name">
                        {{ $company['name'] }}
                    </h1>


                    <div class="company-public-profile__meta">

                        <div class="company-public-profile__rating">

                            <span class="company-public-profile__rating-value">
                                {{ number_format($company['rating'], 1) }}
                            </span>

                            <img
                                src="{{ asset('images/Star.svg') }}"
                                alt=""
                                class="company-public-profile__star"
                            >

                        </div>


                        <span class="company-public-profile__sector">
                            {{ $company['sector'] }}
                        </span>

                    </div>

                </div>

            </div>


            <button
                type="button"
                class="company-public-profile__rating-button"
                data-rating-open
            >
                Dejar una valoración
            </button>

        </div>


        {{-- DESCRIPCIÓN --}}

        <section class="company-public-profile__description">

            <h2 class="company-public-profile__section-title">
                Descripción de la empresa
            </h2>

            <p class="company-public-profile__description-text">
                {{ $company['description'] }}
            </p>

        </section>

    </section>


    {{-- PESTAÑAS --}}

    <div class="company-public-profile__tabs">

        <button
            type="button"
            class="
                company-public-profile__tab
                company-public-profile__tab--active
            "
            data-profile-tab="reviews"
        >
            Valoraciones
        </button>

        <button
            type="button"
            class="company-public-profile__tab"
            data-profile-tab="vacancies"
        >
            Vacantes disponibles
        </button>

    </div>


    {{--  VACANTES  --}}

    <section
        class="company-public-profile__vacancies"
        data-profile-section="vacancies"
        hidden
    >

        @foreach ($vacancies as $vacancy)

            <x-vacancy-card
                :vacancy="$vacancy"
                :href="route('student.vacancies.show', [
                    'id' => $vacancy['id']
                ])"
            />

        @endforeach

    </section>


    {{--  VALORACIONES  --}}

    <section
        class="company-public-profile__reviews"
        data-profile-section="reviews"
    >

        {{-- PUNTUACIÓN --}}

        <div class="company-public-profile__score">

            <h2 class="company-public-profile__score-title">
                Puntuación
            </h2>

            <div class="company-public-profile__score-content">

                <span class="company-public-profile__score-number">
                    {{ number_format($company['rating'], 1) }}
                </span>

                <div class="company-public-profile__score-stars">

                    @for ($star = 1; $star <= 5; $star++)

                        <img
                            src="{{ asset(
                                'images/' .
                                ($star <= round($company['rating'])
                                    ? 'Star.svg'
                                    : 'Starnofill.svg')
                            ) }}"
                            alt=""
                            class="company-public-profile__score-star"
                        >

                    @endfor

                </div>

            </div>

        </div>


        {{-- LISTADO --}}

        <div class="company-public-profile__reviews-content">

            <div class="company-public-profile__reviews-header">

                <span
                    class="company-public-profile__reviews-count"
                    data-reviews-count
                >
                    {{ count($reviews) }} valoraciones
                </span>


                <div class="company-public-profile__sort">

                    <button
                        type="button"
                        class="company-public-profile__sort-trigger"
                        aria-expanded="false"
                        data-sort-trigger
                    >

                        <span data-sort-label>
                            Más recientes
                        </span>

                        <img
                            src="{{ asset('images/Chevrondownvaloration.svg') }}"
                            alt=""
                            class="company-public-profile__sort-icon"
                            data-sort-icon
                        >

                    </button>


                    <div
                        class="company-public-profile__sort-menu"
                        data-sort-menu
                        hidden
                    >

                        <button
                            type="button"
                            class="
                                company-public-profile__sort-option
                                company-public-profile__sort-option--active
                            "
                            data-sort-value="recent"
                        >
                            Más recientes
                        </button>

                        <button
                            type="button"
                            class="company-public-profile__sort-option"
                            data-sort-value="oldest"
                        >
                            Más antiguas
                        </button>

                        <button
                            type="button"
                            class="company-public-profile__sort-option"
                            data-sort-value="best"
                        >
                            Mejor valoradas
                        </button>

                        <button
                            type="button"
                            class="company-public-profile__sort-option"
                            data-sort-value="worst"
                        >
                            Peor valoradas
                        </button>

                    </div>

                </div>

            </div>


            <div
                class="company-public-profile__review-list"
                data-review-list
            ></div>

        </div>

    </section>


    <x-student.rating-modal :company="$company" />

</main>

@endsection