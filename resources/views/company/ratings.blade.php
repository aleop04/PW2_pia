@extends('layouts.company-dashboard')

@section('dashboard-content')

@php

    /*
    |--------------------------------------------------------------------------
    | DATOS TEMPORALES
    |--------------------------------------------------------------------------
    |
    | Después vendrán de la empresa autenticada y de la base de datos.
    |
    */

    $company = [
        'name' => 'Nombre de empresa',
        'image' => 'https://placehold.co/150x145',
        'rating' => 5.0,
    ];


    $reviews = [

        [
            'id' => 1,
            'rating' => 5,
            'date' => '2026-09-08',
            'position' => 'Puesto',
            'duration' => '6 meses',
            'comment' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit ullamcorper, volutpat mattis purus potenti eleifend venenatis facilisi, donec lacus faucibus nam nostra nibh eget. Duis habitasse justo nibh non dapibus risus hendrerit pulvinar.',
        ],

        [
            'id' => 2,
            'rating' => 1,
            'date' => '2026-08-20',
            'position' => 'Puesto',
            'duration' => '3 meses',
            'comment' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit ullamcorper, volutpat mattis purus potenti eleifend venenatis facilisi, donec lacus faucibus nam nostra nibh eget.',
        ],

    ];

@endphp


<section
    class="company-ratings"
    data-company-ratings
>


    {{--  HEADER  --}}

    <div class="company-ratings__header">

        <h1 class="company-ratings__title">
            Valoraciones
        </h1>

        <p class="company-ratings__description">
            Dentro de esta sección se encontrarán todos los usuarios que
            han puntuado y comentado la experiencia laboral que vivieron
            durante el periodo en el que laboraron para tu empresa.
        </p>

    </div>


    {{--  EMPRESA  --}}

    <div class="company-ratings__company">

        <img
            src="{{ $company['image'] }}"
            alt="{{ $company['name'] }}"
            class="company-ratings__company-image"
        >

        <div class="company-ratings__company-info">

            <h2>
                {{ $company['name'] }}
            </h2>

            <div class="company-ratings__company-rating">

                <span>
                    {{ number_format($company['rating'], 1) }}
                </span>

                <img
                    src="{{ asset('images/Star.svg') }}"
                    alt=""
                >

            </div>

        </div>

    </div>


    {{--  VALORACIONES  --}}

    <div class="company-ratings__reviews">


        {{-- CONTROLES --}}

        <div class="company-ratings__reviews-header">

            <h2>
                {{ count($reviews) }} valoraciones
            </h2>


            <div
                class="company-ratings__sort"
                data-ratings-sort
            >

                <button
                    type="button"
                    class="company-ratings__sort-trigger"
                    data-sort-trigger
                    aria-expanded="false"
                >

                    <span data-sort-label>
                        Más recientes
                    </span>

                    <img
                        src="{{ asset('images/Chevrondownvaloration.svg') }}"
                        alt=""
                        class="company-ratings__sort-icon"
                        data-sort-icon
                    >

                </button>


                <div
                    class="company-ratings__sort-menu"
                    data-sort-menu
                    hidden
                >

                    <button
                        type="button"
                        class="
                            company-ratings__sort-option
                            company-ratings__sort-option--active
                        "
                        data-sort-option
                        data-sort-value="recent"
                    >
                        Más recientes
                    </button>

                    <button
                        type="button"
                        class="company-ratings__sort-option"
                        data-sort-option
                        data-sort-value="oldest"
                    >
                        Más antiguas
                    </button>

                </div>

            </div>

        </div>


        {{-- LISTADO --}}

        <div
            class="company-ratings__review-list"
            data-review-list
        >

            @foreach ($reviews as $review)

                <article
                    class="company-ratings__review"
                    data-review
                    data-review-date="{{ $review['date'] }}"
                >


                    {{-- ESTRELLAS + FECHA --}}

                    <div class="company-ratings__review-rating">

                        <div class="company-ratings__review-stars">

                            @for ($star = 1; $star <= 5; $star++)

                                <img
                                    src="{{ asset(
                                        'images/' .
                                        ($star <= $review['rating']
                                            ? 'Star.svg'
                                            : 'Starnofill.svg')
                                    ) }}"
                                    alt=""
                                    class="company-ratings__review-star"
                                >

                            @endfor

                        </div>


                        <span class="company-ratings__review-date">

                            {{ \Carbon\Carbon::parse($review['date'])->format('d/m/Y') }}

                        </span>

                    </div>


                    {{-- INFORMACIÓN --}}

                    <div class="company-ratings__review-info">

                        <h3>
                            {{ $review['position'] }}
                        </h3>

                        <div class="company-ratings__review-meta">

                            <span>
                                {{ $review['duration'] }}
                            </span>

                        </div>

                    </div>


                    {{-- COMENTARIO --}}

                    <p class="company-ratings__review-comment">
                        {{ $review['comment'] }}
                    </p>

                </article>

            @endforeach

        </div>

    </div>

</section>

@endsection