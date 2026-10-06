@extends('layouts.company-dashboard')

@section('dashboard-content')

@php

    /*
    |--------------------------------------------------------------------------
    | VACANTES TEMPORALES
    |--------------------------------------------------------------------------
    |
    | Después vendrán de la base de datos y corresponderán
    | a la empresa autenticada.
    |
    */

    $vacancies = [

        [
            'id' => 1,
            'title' => 'Título de la vacante',
            'company' => 'Nombre de la empresa',
            'location' => 'Ubicación',
            'salary' => '$12,000 - Por mes',
            'modality' => 'Remoto',
            'benefits' => [
                'Seguro dental',
                'Horarios flexibles',
            ],
        ],

        [
            'id' => 2,
            'title' => 'Título de la vacante',
            'company' => 'Nombre de la empresa',
            'location' => 'Ubicación',
            'salary' => '$15,000 - Por mes',
            'modality' => 'Presencial',
            'benefits' => [
                'Seguro de vida',
                'Vales de despensa',
            ],
        ],

        [
            'id' => 3,
            'title' => 'Título de la vacante',
            'company' => 'Nombre de la empresa',
            'location' => 'Ubicación',
            'salary' => '$10,000 - Por quincena',
            'modality' => 'Híbrido',
            'benefits' => [
                'Trabajo desde casa',
                'Seguro dental',
            ],
        ],

        [
            'id' => 4,
            'title' => 'Título de la vacante',
            'company' => 'Nombre de la empresa',
            'location' => 'Ubicación',
            'salary' => '$14,000 - Por mes',
            'modality' => 'Remoto',
            'benefits' => [
                'Horarios flexibles',
                'Seguro de vida',
            ],
        ],

        [
            'id' => 5,
            'title' => 'Título de la vacante',
            'company' => 'Nombre de la empresa',
            'location' => 'Ubicación',
            'salary' => '$16,000 - Por mes',
            'modality' => 'Presencial',
            'benefits' => [
                'Vales de despensa',
                'Servicio de comedor',
            ],
        ],

        [
            'id' => 6,
            'title' => 'Título de la vacante',
            'company' => 'Nombre de la empresa',
            'location' => 'Ubicación',
            'salary' => '$11,000 - Por semana',
            'modality' => 'Híbrido',
            'benefits' => [
                'Seguro médico',
                'Horarios flexibles',
            ],
        ],

    ];

@endphp


<section class="company-vacancies">

    {{-- ========================================
         TITLE
    ========================================= --}}

    <h1 class="company-vacancies__title">
        Vacantes publicadas
    </h1>


    {{-- ========================================
         VACANCIES GRID
    ========================================= --}}

    <div class="company-vacancies__grid">

        @foreach ($vacancies as $vacancy)

            <x-vacancy-card
                :vacancy="$vacancy"
                variant="company"
                :href="route(
                    'company.vacancies.show',
                    ['id' => $vacancy['id']]
                )"
            />

        @endforeach

    </div>

</section>

@endsection