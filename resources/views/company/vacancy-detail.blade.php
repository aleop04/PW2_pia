@extends('layouts.company')

@section('content')

<main
    class="vacancy-detail-page"
    data-company-vacancy-detail
    data-vacancy-id="{{ $vacancy['id'] }}"
    data-vacancies-url="{{ route('company.vacancies.index') }}"
>
    @include('components.flow-feedback')

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

    <form id="delete-vacancy-form" method="POST" action="{{ route('company.vacancies.destroy', $vacancy['id']) }}" hidden>
        @csrf
        @method('DELETE')
    </form>

@endsection
