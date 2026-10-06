@extends('layouts.student')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | DATOS TEMPORALES DEL ESTUDIANTE
    |--------------------------------------------------------------------------
    |
    | Después vendrán de la base de datos.
    |
    */

    $student = [
        'firstName' => 'Nombre',
        'paternalSurname' => 'Apellido Paterno',
        'maternalSurname' => 'Apellido Materno',

        'email' => 'correo@gmail.com',
        'phone' => '1234567890',
        'location' => 'Ubicación',

        'birthDate' => '2003-01-01',
        'birthDateValue' => '2003-01-01',

        'avatar' => null,
    ];


    /*
    |--------------------------------------------------------------------------
    | POSTULACIONES ENVIADAS
    |--------------------------------------------------------------------------
    |
    | Por ahora cada elemento contiene los datos de la vacante.
    | Después estas vacantes vendrán de las postulaciones del estudiante.
    |
    */

    $applications = [

        [
            'id' => 1,

            'title' => 'Título de la vacante',
            'company' => 'Nombre de la empresa',
            'location' => 'Ubicación',

            'salary' => 'Sueldo',
            'modality' => 'Modalidad',

            'benefits' => [
                'Prestaciones',
                'Prestaciones',
                'Prestaciones',
                'Prestaciones',
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
                'Prestaciones',
                'Prestaciones',
                'Prestaciones',
                'Prestaciones',
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
                'Prestaciones',
                'Prestaciones',
                'Prestaciones',
                'Prestaciones',
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
                'Prestaciones',
                'Prestaciones',
                'Prestaciones',
                'Prestaciones',
            ],
        ],

    ];

@endphp


<main
    class="student-profile-page"
    data-student-profile-page
>

    {{-- PERFIL  --}}

    <x-student.profile-card
        :student="$student"
    />


    {{-- POSTULACIONES ENVIADAS --}}

        <section class="student-profile-page__applications">

            <h1 class="student-profile-page__title">
                Postulaciones enviadas
            </h1>


            {{-- VACANTES GUARDADAS --}}

            <div class="student-profile-page__applications-actions">

                <a
                    href="{{ route('student.bookmarks') }}"
                    class="student-profile-page__bookmarks"
                >
                    <img
                        src="{{ asset('images/Bookmark.svg') }}"
                        alt=""
                        class="student-profile-page__bookmarks-icon"
                    >

                    <span>
                        Vacantes guardadas
                    </span>
                </a>

            </div>


            {{-- POSTULACIONES --}}

            <div class="student-profile-page__application-grid">

                @foreach ($applications as $application)

                    <x-vacancy-card
                        :vacancy="$application"
                        :href="route('student.vacancies.show', [
                            'id' => $application['id']
                        ])"
                    />

                @endforeach

            </div>

        </section>

</main>

@endsection