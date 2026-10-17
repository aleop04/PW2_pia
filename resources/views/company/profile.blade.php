@extends('layouts.company')

@section('content')
@php
    // La sesión web recupera esta cuenta de la colección users de MongoDB.
    $user = auth('web')->user();
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
    $sectorName = $user->sector === 'other'
        ? $user->custom_sector
        : ($sectorLabels[$user->sector] ?? $user->sector);
@endphp

<section class="company-profile" data-company-profile aria-labelledby="company-profile-title">
    @include('components.flow-feedback')
    <div class="company-profile__header">
        <img class="company-profile__image" src="{{ $user->logo_path ? Storage::disk('public')->url($user->logo_path) : asset('images/User.svg') }}" alt="Logo de {{ $user->company_name }}" />
        <div class="company-profile__identity">
            <h1 class="company-profile__name" id="company-profile-title">{{ $user->company_name }}</h1>
            <p>Datos de tu cuenta empresarial</p>
        </div>
    </div>

    <div class="company-profile__content">
        <div class="company-profile__data">
            <div class="company-profile__fields">
                <div class="company-profile__field">
                    <label for="company-rfc">RFC</label>
                    <input id="company-rfc" class="company-profile__locked-input" type="text" value="{{ $user->rfc }}" disabled>
                </div>
                <div class="company-profile__field">
                    <label for="company-sector">Sector</label>
                    <input id="company-sector" class="company-profile__locked-input" type="text" value="{{ $sectorName }}" disabled>
                </div>
                <div class="company-profile__field">
                    <label for="company-email">Correo electrónico</label>
                    <input id="company-email" class="company-profile__locked-input" type="email" value="{{ $user->email }}" disabled>
                </div>
                <div class="company-profile__location">
                    <div class="company-profile__field">
                        <label for="company-state">Estado</label>
                        <input id="company-state" type="text" name="state" form="company-profile-form" value="{{ old('state', $user->state) }}" data-company-editable @unless($errors->any()) readonly @endunless>
                    </div>
                    <div class="company-profile__field">
                        <label for="company-city">Ciudad</label>
                        <input id="company-city" type="text" name="city" form="company-profile-form" value="{{ old('city', $user->city) }}" data-company-editable @unless($errors->any()) readonly @endunless>
                    </div>
                </div>
            </div>
        </div>

        <div class="company-profile__description">
            <form id="company-profile-form" class="nextstep-profile-form" method="POST" action="{{ route('company.profile.update') }}" enctype="multipart/form-data" data-company-profile-form>
                @csrf
                <h2>Descripción de la empresa</h2>
                <label for="company-description">Cuéntales a los estudiantes sobre tu empresa</label>
                <p class="nextstep-profile-form__hint">¿Qué hacen y en qué rubro trabajan? ¿A quién ayudan y qué oportunidades ofrecen?</p>
                <textarea id="company-description" name="description" maxlength="3000" rows="11" data-company-editable @unless($errors->any()) readonly @endunless placeholder="Somos una empresa dedicada al desarrollo de soluciones digitales para pequeños negocios. Diseñamos sitios web y sistemas que les ayudan a organizar sus ventas, atender clientes y simplificar tareas diarias. Trabajamos en el sector de tecnología y diseño. Buscamos estudiantes interesados en desarrollo de software y diseño de interfaces para participar en proyectos reales junto con nuestro equipo.">{{ old('description', $user->description) }}</textarea>
                <label for="company-logo">Logo de la empresa (JPG, PNG o WebP, máximo 2 MB)</label>
                <input id="company-logo" type="file" name="logo" accept="image/jpeg,image/png,image/webp" @unless($errors->any()) disabled @endunless data-company-logo>
                <div class="nextstep-profile-form__actions company-profile__form-actions">
                    <button type="button" class="company-profile__edit" data-company-edit>Editar</button>
                    <button type="submit" class="company-profile__save" data-company-save @unless($errors->any()) disabled @endunless>Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
