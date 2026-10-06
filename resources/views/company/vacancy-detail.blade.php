@extends('layouts.company')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | VACANTE TEMPORAL
    |--------------------------------------------------------------------------
    |
    | Después estos datos vendrán de la base de datos utilizando
    | el ID recibido en la ruta.
    |
    */

    $vacancyId = request()->route('id');

    $vacancy = [
        'id' => $vacancyId,
        'title' => 'Título de la vacante',
        'company' => 'Nombre de la empresa',
        'location' => 'Ubicación',
        'salary' => '$12,000 - Por mes',
        'modality' => 'Remoto',
        'stayDuration' => '6 meses',

        'benefits' => [
            'Seguro dental',
            'Horarios flexibles',
            'Trabajo desde casa',
        ],

        'jobType' => 'Tiempo completo',

        'description' =>
            'Lorem ipsum dolor sit amet consectetur adipiscing elit. '
            . 'Esta es la descripción actual de la vacante publicada por la empresa.',
    ];

@endphp


<main
    class="vacancy-detail-page"
    data-company-vacancy-detail
    data-vacancy-id="{{ $vacancy['id'] }}"
    data-vacancies-url="{{ route('company.vacancies.index') }}"
>

    <x-vacancy-detail
        :vacancy="$vacancy"
        :company-href="route('company.profile')"
    >

        <x-slot:actions>

            {{-- EDITAR --}}

            <a
                href="{{ route(
                    'company.vacancies.edit',
                    ['id' => $vacancy['id']]
                ) }}"
                class="vacancy-detail__primary-button"
            >
                Editar datos
            </a>


            {{-- ELIMINAR --}}

            <button
                type="button"
                class="vacancy-detail__primary-button"
                data-delete-vacancy
            >
                Eliminar
            </button>

        </x-slot:actions>

    </x-vacancy-detail>

</main>


{{--  MODAL DE ELIMINACIÓN  --}}

@include('components.company.delete-vacancy-modal')

@endsection