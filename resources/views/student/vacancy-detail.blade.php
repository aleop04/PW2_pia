@extends('layouts.student')

@section('content')

<main
    class="vacancy-detail-page"
    data-student-vacancy-detail
    data-open-on-error="{{ $errors->any() ? 'true' : 'false' }}"
>
    @include('components.flow-feedback')


    <x-vacancy-detail
        :vacancy="$vacancy"
        :actions-at-end="true"
        :company-href="route('student.companies.show', [
            'id' => $vacancy['companyId']
        ])"
    >

        <x-slot:actions>

            {{-- POSTULARSE --}}

            <button
                type="button"
                class="vacancy-detail__primary-button"
                data-application-open
                @if($alreadyApplied) hidden @endif
            >
                Postularse
            </button>
            @if($alreadyApplied)<span class="flow-feedback flow-feedback--success">Postulación enviada</span>@endif

        </x-slot:actions>

    </x-vacancy-detail>


    @include('student.partials.application-modal', ['vacancy' => $vacancy, 'student' => $student])

</main>

@endsection
