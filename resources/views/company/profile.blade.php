@extends('layouts.company')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | DATOS TEMPORALES DE LA EMPRESA
    |--------------------------------------------------------------------------
    |
    | Después estos datos vendrán de la empresa autenticada en la base
    | de datos.
    |
    */

    $company = [
        'name' => 'Nombre de empresa',
        'rating' => '5.0',
        'rfc' => '',
        'sector' => '',
        'email' => '',
        'state' => '',
        'city' => '',

        'description' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit ullamcorper, volutpat mattis purus potenti eleifend venenatis facilisi, donec lacus faucibus nam nostra nibh eget. Duis habitasse justo nibh non dapibus risus hendrerit pulvinar, cubilia faucibus dictumst penatibus nunc sagittis litora, auctor nostra mattis in mi taciti turpis. Semper congue convallis erat suscipit vehicula eget libero aliquam facilisis dictum a malesuada justo quis, consequat nullam litora nostra ridiculus morbi sed ligula risus felis taciti varius.

Scelerisque habitasse quis nulla tellus curae interdum inceptos ligula, eros natoque suspendisse mauris rhoncus euismod iaculis imperdiet platea, egestas vulputate hac placerat fermentum lobortis sem. Mollis rutrum maecenas quam ut nec viverra nam felis accumsan odio, hendrerit feugiat fusce est phasellus praesent ac facilisis pretium, tempor cum dapibus aliquet libero pulvinar a taciti aenean. Dictum hac placerat ad vel mollis sollicitudin, blandit metus facilisis nulla arcu feugiat, curae enim aptent sodales rutrum.

Mollis dictumst montes praesent potenti metus semper conubia scelerisque, porta feugiat ligula tortor pharetra auctor rhoncus, enim quam proin nisl litora dapibus tellus. Malesuada erat augue at congue molestie risus vestibulum libero, odio magna vel quisque senectus ac praesent montes facilisi, torquent semper mus lobortis in ullamcorper dis. A penatibus vel conubia bibendum congue nulla porttitor ultrices fringilla fames ornare, gravida quisque massa ad eleifend id venenatis urna volutpat viverra. Dis pretium risus tellus iaculis urna, libero sociis blandit cubilia malesuada, sagittis penatibus auctor ridiculus.',
    ];

@endphp


<section
    class="company-profile"
    data-company-profile
>

    {{-- CABECERA --}}

    <div class="company-profile__header">

        <img
            class="company-profile__image"
            src="https://placehold.co/215x209"
            alt="Logo de {{ $company['name'] }}"
        >

        <div class="company-profile__identity">

            <h1 class="company-profile__name">
                {{ $company['name'] }}
            </h1>

            <div class="company-profile__rating">

                <span>
                    {{ $company['rating'] }}
                </span>

                <span class="company-profile__star">
                    ★
                </span>

            </div>

        </div>

    </div>


    {{-- INFORMACIÓN --}}

    <div class="company-profile__content">


        {{-- COLUMNA IZQUIERDA --}}

        <div class="company-profile__data">

            <div class="company-profile__fields">


                {{-- RFC --}}

                <div class="company-profile__field">

                    <label for="company-rfc">
                        RFC
                    </label>

                    <input
                        id="company-rfc"
                        class="company-profile__locked-input"
                        type="text"
                        value="{{ $company['rfc'] }}"
                        disabled
                    >

                </div>


                {{-- SECTOR --}}

                <div class="company-profile__field">

                    <label for="company-sector">
                        Sector
                    </label>

                    <input
                        id="company-sector"
                        type="text"
                        value="{{ $company['sector'] }}"
                        disabled
                        data-profile-field
                    >

                </div>


                {{-- CORREO --}}

                <div class="company-profile__field">

                    <label for="company-email">
                        Correo electrónico
                    </label>

                    <input
                        id="company-email"
                        class="company-profile__locked-input"
                        type="email"
                        value="{{ $company['email'] }}"
                        disabled
                    >

                </div>


                {{-- ESTADO + CIUDAD --}}

                <div class="company-profile__location">

                    <div class="company-profile__field">

                        <label for="company-state">
                            Estado
                        </label>

                        <input
                            id="company-state"
                            type="text"
                            value="{{ $company['state'] }}"
                            disabled
                            data-profile-field
                        >

                    </div>


                    <div class="company-profile__field">

                        <label for="company-city">
                            Ciudad
                        </label>

                        <input
                            id="company-city"
                            type="text"
                            value="{{ $company['city'] }}"
                            disabled
                            data-profile-field
                        >

                    </div>

                </div>


                {{-- CONTRASEÑAS: SOLO MODO EDICIÓN --}}

                <div
                    class="company-profile__password-fields"
                    data-password-fields
                    hidden
                >

                    <div class="company-profile__field">

                        <label for="company-password">
                            Contraseña
                        </label>

                        <input
                            id="company-password"
                            type="password"
                            autocomplete="new-password"
                            data-password
                        >

                    </div>


                    <div class="company-profile__field">

                        <label for="company-password-confirmation">
                            Confirmar contraseña
                        </label>

                        <input
                            id="company-password-confirmation"
                            type="password"
                            autocomplete="new-password"
                            data-password-confirmation
                        >

                    </div>

                </div>

            </div>


            <button
                class="company-profile__edit-button"
                type="button"
                data-edit-button
            >
                Editar datos
            </button>

        </div>


        {{-- COLUMNA DERECHA --}}

        <div class="company-profile__description">

            <h2>
                Descripción de la empresa
            </h2>


            {{-- MODO LECTURA --}}

            <p
                class="company-profile__description-text"
                data-description-text
            >{{ $company['description'] }}</p>


            {{-- MODO EDICIÓN --}}

            <textarea
                class="company-profile__description-input"
                data-description-input
                hidden
            >{{ $company['description'] }}</textarea>

        </div>

    </div>

</section>

@endsection