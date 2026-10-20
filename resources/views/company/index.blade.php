@extends('layouts.company-dashboard')

@section('dashboard-content')

@php
    $companyName = auth('web')->user()->company_name;

    $summaryCards = [
        [
            'icon' => 'Eye.svg',
            'value' => $profileVisitorCount,
            'description' => 'Usuarios que han entrado a tu perfil',
        ],
        [
            'icon' => 'Users.svg',
            'value' => $applicationUserCount,
            'description' => 'Usuarios que se han postulado en tus vacantes',
        ],
        [
            'icon' => 'Starwhite.svg',
            'value' => $reviewerCount,
            'description' => 'Usuarios que han valorado tus vacantes',
        ],
    ];
@endphp


<section class="company-dashboard">

    {{-- ENCABEZADO --}}
    <div class="company-dashboard__header">

        <h1 class="company-section-title">
            Dashboard
        </h1>

        <p class="company-dashboard__welcome">
            Bienvenido, {{ $companyName }}. Dentro de esta sección tendrás
            acceso a la información de interacción que los usuarios tienen
            con tu cuenta y las postulaciones que compartas.
        </p>

    </div>


    {{-- CONTENIDO --}}
    <div class="company-dashboard__content">


        {{-- TARJETAS DE ESTADÍSTICAS --}}
        <div class="company-dashboard__summary">

            @foreach ($summaryCards as $card)

                <article class="company-dashboard__summary-card">

                    <div class="company-dashboard__summary-top">

                        <div class="company-dashboard__summary-value">

                            <img
                                src="{{ asset('images/' . $card['icon']) }}"
                                alt=""
                                class="company-dashboard__summary-icon"
                            >

                            <span>
                                {{ $card['value'] }}
                            </span>

                        </div>

                    </div>

                    <p class="company-dashboard__summary-description">
                        {{ $card['description'] }}
                    </p>

                </article>

            @endforeach

        </div>


        {{-- BLOQUES INFERIORES --}}
        <div class="company-dashboard__bottom">


            {{-- ALCANCE TOTAL --}}
            <article class="company-dashboard__reach-card">

                <div class="company-dashboard__reach-graphic">

                    <img
                        src="{{ asset('images/Barchart.svg') }}"
                        alt=""
                        class="company-dashboard__reach-icon"
                    >

                </div>

                <div class="company-dashboard__reach-info">

                    <strong>
                        {{ $profileReachCount }}
                    </strong>

                    <span>
                        Total de alcance de tu perfil
                    </span>

                </div>

            </article>


            {{-- SOLICITUDES RECIBIDAS --}}
            <article class="company-dashboard__applications-card">


                {{-- CABECERA --}}
                <div class="company-dashboard__applications-header">

                    <h2>
                        Solicitudes recibidas
                    </h2>

                    <a
                        href="{{ route('company.applications') }}"
                        class="company-dashboard__applications-link"
                    >

                        <span>
                            Ver todas las solicitudes
                        </span>

                        <img
                            src="{{ asset('images/Arrowright.svg') }}"
                            alt=""
                        >

                    </a>

                </div>


                {{-- TABLA --}}
                <div class="company-dashboard__applications-table">


                    {{-- ENCABEZADOS --}}
                    <div
                        class="
                            company-dashboard__application-row
                            company-dashboard__application-row--header
                        "
                    >

                        <span>Aplicante</span>
                        <span>Fecha de envío</span>
                        <span>CV</span>
                        <span>Estatus</span>

                    </div>


                    {{-- FILAS --}}
                    @forelse ($applications as $application)

                        <div class="company-dashboard__application-row">

                            <span
                                class="company-dashboard__application-name"
                                title="{{ $application['name'] }}"
                            >
                                {{ $application['name'] }}
                            </span>

                            <span>
                                {{ $application['date'] }}
                            </span>

                            <span
                                class="company-dashboard__application-cv"
                                title="{{ $application['cv'] }}"
                            >
                                {{ $application['cv'] }}
                            </span>

                            <span
                                class="
                                    company-dashboard__status
                                    company-dashboard__status--{{ $application['statusClass'] }}
                                "
                            >
                                {{ $application['status'] }}
                            </span>

                        </div>

                    @empty

                        <div class="company-dashboard__empty">
                            Aún no recibes postulaciones.
                        </div>

                    @endforelse

                </div>

            </article>

        </div>

    </div>

</section>

@endsection