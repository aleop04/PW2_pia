@extends('layouts.student')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | VACANTES GUARDADAS TEMPORALES
    |--------------------------------------------------------------------------
    |
    | Después vendrán de la base de datos según el estudiante autenticado.
    |
    */

    $savedVacancies = [

        [
            'id' => 1,

            'title' => 'Título de la vacante',
            'company' => 'Nombre de la empresa',
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

            'title' => 'Título de la vacante',
            'company' => 'Nombre de la empresa',
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
            'id' => 3,

            'title' => 'Título de la vacante',
            'company' => 'Nombre de la empresa',
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
            'id' => 4,

            'title' => 'Título de la vacante',
            'company' => 'Nombre de la empresa',
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
            'id' => 5,

            'title' => 'Título de la vacante',
            'company' => 'Nombre de la empresa',
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
            'id' => 6,

            'title' => 'Título de la vacante',
            'company' => 'Nombre de la empresa',
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

    ];

@endphp


<main class="bookmarks-page">

    {{--  BANNER  --}}

    <section
        class="bookmarks-page__banner"
        style="background-image: url('{{ asset('images/BookmarksBanner.png') }}');"
    >

        <h1 class="bookmarks-page__title">
            Mis vacantes guardadas
        </h1>

    </section>


    {{--  VACANTES GUARDADAS --}}

    <section class="bookmarks-page__vacancies">

        @forelse ($savedVacancies as $vacancy)

            <x-vacancy-card
                :vacancy="$vacancy"
                :href="route('student.vacancies.show', [
                    'id' => $vacancy['id']
                ])"
            />

        @empty

            <p class="bookmarks-page__empty">
                Aún no tienes vacantes guardadas.
            </p>

        @endforelse

    </section>

</main>

@endsection