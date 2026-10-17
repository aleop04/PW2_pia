@extends('layouts.student')

@section('content')

<main
    class="student-profile-page"
    data-student-profile-page
>

    {{-- Perfil --}}
    <x-student.profile-card
        :student="$student"
    />


    {{-- Mis postulaciones --}}
    <section
        class="student-profile-page__applications"
        aria-labelledby="student-profile-applications-title"
    >

        <h1
            class="student-profile-page__title"
            id="student-profile-applications-title"
        >
            Mis postulaciones
        </h1>


        {{-- Vacantes guardadas --}}
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


        {{-- Postulaciones --}}
        <div class="student-profile-page__application-grid">

            @forelse ($applications as $application)

                <x-vacancy-card
                    :vacancy="$application"
                    :href="route('student.vacancies.show', [
                        'id' => $application['id']
                    ])"
                />

            @empty

                <p class="student-profile-page__empty">
                    Aún no has enviado postulaciones.
                </p>

            @endforelse

        </div>

    </section>

</main>

@endsection