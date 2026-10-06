@extends('layouts.company')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | MEMBRESÍA TEMPORAL
    |--------------------------------------------------------------------------
    |
    | Después el tipo de membresía vendrá de la empresa autenticada.
    |
    */

    $membershipType = 'premium';

    $memberships = [

        'basic' => [
            'name' => 'Basic',
            'price' => 150,

            'summary' =>
                'Actualmente eres miembro del plan mensual Basic en la plataforma NextStep',

            'benefits' => [
                'Capacidad de publicar 8 vacantes diferentes',
                '20% más de alcance general',
                'Visibilidad estándar en las páginas principales',
                'Perfil empresarial disponible para los usuarios',
            ],

            'class' => 'membership-benefits--basic',
        ],


        'plus' => [
            'name' => 'Plus',
            'price' => 350,

            'summary' =>
                'Actualmente eres miembro del plan mensual Plus en la plataforma NextStep',

            'benefits' => [
                'Capacidad de publicar 16 vacantes diferentes',
                '60% más de alcance general',
                'Tus publicaciones tendrán más visibilidad en las páginas principales',
                'Tu perfil empresarial será mayormente promocionado para los usuarios',
            ],

            'class' => 'membership-benefits--plus',
        ],


        'premium' => [
            'name' => 'Premium',
            'price' => 550,

            'summary' =>
                'Actualmente eres miembro del plan mensual Premium en la plataforma NextStep',

            'benefits' => [
                'Capacidad ilimitada de publicar vacantes',
                'Mayor alcance general',
                'Máxima visibilidad en las páginas principales',
                'Mayor promoción del perfil empresarial',
            ],

            'class' => 'membership-benefits--premium',
        ],

    ];


    $currentMembership = $memberships[$membershipType];

@endphp


<section class="membership-page">

    {{-- CABECERA --}}

    <div class="membership-page__header">

        <h1>
            Tu suscripción
        </h1>

        <p>
            Información de tu suscripción actual.
        </p>

    </div>


    <div class="membership-page__content">


        {{-- MEMBRESÍA ACTUAL --}}

        <div class="membership-page__current">

            <div class="membership-page__current-info">

                <h2>
                    Miembro del plan {{ $currentMembership['name'] }}
                    - ${{ $currentMembership['price'] }} / mes
                </h2>

                <p>
                    {{ $currentMembership['summary'] }}
                </p>

            </div>

        </div>


        {{-- BENEFICIOS --}}

        <div
            class="
                membership-benefits
                {{ $currentMembership['class'] }}
            "
        >

            <div class="membership-benefits__header">

                <h2>
                    Beneficios del plan
                    {{ $currentMembership['name'] }}
                </h2>


                <a
                    href="{{ route('company.membership.change') }}"
                    class="membership-benefits__change"
                >

                    <span>
                        Cambiar suscripción mensual
                    </span>

                    <img
                        src="{{ asset('images/Arrowright.svg') }}"
                        alt=""
                    >

                </a>

            </div>


            <div class="membership-benefits__list">

                @foreach ($currentMembership['benefits'] as $benefit)

                    <div class="membership-benefits__item">

                        <span>
                            {{ $benefit }}
                        </span>

                        <img
                            src="{{ asset('images/Check.svg') }}"
                            alt=""
                        >

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</section>

@endsection