@extends('layouts.company')

@section('content')
@php
    $user = $user ?? auth('web')->user();

    $sectorLabels = [
        'technology' => 'Tecnología e Informática',
        'health' => 'Salud y Medicina',
        'education' => 'Educación',
        'finance' => 'Finanzas y Contabilidad',
        'engineering' => 'Ingeniería',
        'business' => 'Administración y Negocios',
        'marketing' => 'Marketing y Publicidad',
        'sales' => 'Ventas y Comercio',
        'rh' => 'Recursos Humanos',
        'law' => 'Derecho',
        'architecture' => 'Arquitectura y Diseño',
        'communication' => 'Comunicación y Medios',
        'tourism' => 'Turismo, Hotelería y Gastronomía',
        'manufacturing' => 'Industria y Manufactura',
        'construction' => 'Construcción',
        'logistics' => 'Logística y Transporte',
        'energy' => 'Energía y Medio Ambiente',
        'agriculture' => 'Agricultura y Agroindustria',
        'science' => 'Ciencia e Investigación',
        'government' => 'Sector Público y Gobierno',
        'other' => 'Otro',
    ];

    $currentSector = old('sector', $user->sector);

    $sectorName = $user->sector === 'other'
        ? $user->custom_sector
        : ($sectorLabels[$user->sector] ?? $user->sector);
@endphp

<section
    class="company-profile"
    data-company-profile
    data-company-initial-edit="{{ $errors->any() ? 'true' : 'false' }}"
    aria-labelledby="company-profile-title"
>

    @include('components.flow-feedback')

    <form
        id="company-profile-form"
        class="company-profile__form"
        method="POST"
        action="{{ route('company.profile.update') }}"
        enctype="multipart/form-data"
        data-company-profile-form
    >
        @csrf

        {{--  CABECERA  --}}
        <div class="company-profile__header">

            <div class="company-profile__image-wrapper">

                <img
                    class="company-profile__image"
                    src="{{ $user->logo_path
                        ? Storage::disk('public')->url($user->logo_path)
                        : asset('images/User.svg') }}"
                    alt="Logo de {{ $user->company_name }}"
                    data-company-image
                >

                <label
                    class="company-profile__image-overlay"
                    for="company-logo"
                    aria-label="Cambiar logo de la empresa"
                >
                    <span>Cambiar logo</span>
                </label>

                <input
                    id="company-logo"
                    class="company-profile__image-input"
                    type="file"
                    name="logo"
                    accept="image/jpeg,image/png,image/webp"
                    data-company-logo
                >

            </div>

            <div class="company-profile__identity">

                <h1
                    class="company-profile__name"
                    id="company-profile-title"
                >
                    {{ $user->company_name }}
                </h1>

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
                            value="{{ $user->rfc }}"
                            disabled
                        >

                    </div>


                    {{-- SECTOR --}}
                    <div class="company-profile__field">

                        <label for="company-sector">
                            Sector
                        </label>

                        {{-- Vista normal --}}
                        <input
                            id="company-sector-view"
                            class="company-profile__locked-display"
                            type="text"
                            value="{{ $sectorName }}"
                            disabled
                            data-company-sector-view
                        >

                        {{-- Vista edición --}}
                        <select
                            id="company-sector"
                            name="sector"
                            class="company-profile__select"
                            data-company-sector
                            hidden
                        >
                            @foreach ($sectorLabels as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    @selected($currentSector === $value)
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                    </div>


                    {{-- OTRO SECTOR --}}
                    <div
                        class="company-profile__field"
                        data-company-custom-sector-wrapper
                        hidden
                    >

                        <label for="company-custom-sector">
                            Especifica el sector
                        </label>

                        <input
                            id="company-custom-sector"
                            type="text"
                            name="custom_sector"
                            maxlength="100"
                            value="{{ old('custom_sector', $user->custom_sector) }}"
                            data-company-custom-sector
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
                            value="{{ $user->email }}"
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
                                name="state"
                                maxlength="100"
                                value="{{ old('state', $user->state) }}"
                                readonly
                                data-company-editable
                            >

                        </div>

                        <div class="company-profile__field">

                            <label for="company-city">
                                Ciudad
                            </label>

                            <input
                                id="company-city"
                                type="text"
                                name="city"
                                maxlength="100"
                                value="{{ old('city', $user->city) }}"
                                readonly
                                data-company-editable
                            >

                        </div>

                    </div>


                    {{-- CONTRASEÑAS --}}
                    <div
                        class="company-profile__password-fields"
                        data-company-password-fields
                        hidden
                    >

                        <div class="company-profile__field">

                            <label for="company-password">
                                Contraseña
                            </label>

                            <input
                                id="company-password"
                                type="password"
                                name="password"
                                minlength="8"
                                maxlength="72"
                                autocomplete="new-password"
                                placeholder="Dejar vacío para conservarla"
                                data-company-password
                            >

                        </div>

                        <div class="company-profile__field">

                            <label for="company-password-confirmation">
                                Confirmar contraseña
                            </label>

                            <input
                                id="company-password-confirmation"
                                type="password"
                                name="password_confirmation"
                                minlength="8"
                                maxlength="72"
                                autocomplete="new-password"
                                data-company-password
                            >

                        </div>

                    </div>

                </div>


                {{-- BOTONES --}}
                <div class="company-profile__actions">

                    <button
                        class="company-profile__edit-button"
                        type="button"
                        data-company-edit
                    >
                        Editar datos
                    </button>

                    <button
                        class="company-profile__save-button"
                        type="submit"
                        data-company-save
                        hidden
                    >
                        Guardar datos
                    </button>

                    <button
                        class="company-profile__cancel-button"
                        type="button"
                        data-company-cancel
                        hidden
                    >
                        Cancelar
                    </button>

                </div>

            </div>


            {{-- DESCRIPCIÓN --}}
            <div class="company-profile__description">

                <h2>
                    Descripción de la empresa
                </h2>

                {{-- Modo lectura --}}
                <p
                    class="company-profile__description-text"
                    data-company-description-view
                >{{ $user->description }}</p>

                {{-- Modo edición --}}
                <textarea
                    id="company-description"
                    name="description"
                    class="company-profile__description-input"
                    maxlength="3000"
                    rows="11"
                    data-company-description-input
                    hidden
                >{{ old('description', $user->description) }}</textarea>

            </div>

        </div>

    </form>

</section>
@endsection