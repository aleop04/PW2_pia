@extends('layouts.student')

@section('content')

<main
    class="student-profile-page"
    data-student-profile-page
>

    {{-- ------- perfil del estudiante ------- --}}

    <x-student.profile-card :student="$student" />


    {{-- ------- vacantes y postulaciones ------- --}}

    <section class="student-profile-page__applications">

        {{-- ------- vacantes guardadas ------- --}}

        <h1
            class="student-profile-page__title"
            id="vacantes-guardadas"
        >
            Vacantes guardadas
        </h1>

        <div class="student-profile-page__saved-grid">

            @forelse ($savedVacancies as $vacancy)

                <div class="student-profile-page__saved-item">

                    {{-- tarjeta que abre el detalle --}}
                    <x-vacancy-card
                        :vacancy="$vacancy"
                        :href="route('student.vacancies.show', [
                            'id' => $vacancy['id']
                        ])"
                    />

                    {{-- boton para quitar la vacante --}}
                    <form
                        method="POST"
                        action="{{ route('student.bookmarks.destroy', $vacancy['id']) }}"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="student-profile-page__remove-bookmark"
                        >
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


        {{-- ------- postulaciones enviadas ------- --}}

        <h2 class="student-profile-page__subtitle">
            Mis postulaciones
        </h2>

        <div class="student-profile-page__application-grid">

            @forelse ($applications as $application)

                {{-- abre el detalle de la vacante --}}
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