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


    {{-- Vacantes guardadas y postulaciones --}}
    <section
        class="student-profile-page__applications"
        aria-labelledby="student-profile-saved-title"
    {{-- Mis postulaciones --}}
    <section
        class="student-profile-page__applications"
        aria-labelledby="student-profile-applications-title"
    >

        <h1
            class="student-profile-page__title"
            id="student-profile-saved-title"
        >
            Vacantes guardadas
        </h1>

        <div class="student-profile-page__saved-grid">
            id="student-profile-applications-title"
        >
            Mis postulaciones
        </h1>
            @forelse ($savedVacancies as $vacancy)
                <div class="student-profile-page__saved-item">
                    <x-vacancy-card
                        :vacancy="$vacancy"
                        :href="route('student.vacancies.show', ['id' => $vacancy['id']])"
                    />
                    <form method="POST" action="{{ route('student.bookmarks.destroy', $vacancy['id']) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="student-profile-page__remove-bookmark">
                            Quitar de guardadas
                        </button>
                    </form>
                </div>

            @empty

                <p class="student-profile-page__empty">
                    Aún no has guardado vacantes.
                </p>

            @endforelse

        </div>

        <h2 class="student-profile-page__subtitle" id="student-profile-applications-title">
            Mis postulaciones
        </h2>

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
