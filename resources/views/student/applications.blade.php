@extends('layouts.student')

@section('content')
<main class="student-applications-page">
    <header class="student-applications-page__header">
        <h1>Mis postulaciones</h1>
        <p>Aquí puedes consultar las vacantes a las que te postulaste y el estado de cada solicitud.</p>
        @include('components.flow-feedback')
    </header>

    <div class="student-applications-page__links">
        <a href="{{ route('student.home') }}">Explorar vacantes</a>
        <a href="{{ route('student.bookmarks') }}">Vacantes guardadas</a>
    </div>

    <section class="student-applications-page__list" aria-label="Postulaciones enviadas">
        @forelse($applications as $application)
            <article class="student-applications-page__card">
                <h2>{{ $application['title'] }}</h2>
                <p>{{ $application['company'] }}</p>
                <p>Enviada el {{ $application['date'] }}</p>
                <span class="student-applications-page__status student-applications-page__status--{{ $application['status'] }}">
                    {{ ['pending' => 'Pendiente', 'accepted' => 'Aceptada', 'rejected' => 'Rechazada'][$application['status']] ?? $application['status'] }}
                </span>
                @if($application['available'])
                    <a class="student-applications-page__detail" href="{{ route('student.vacancies.show', $application['vacancy_id']) }}">Ver descripción de la vacante</a>
                @endif
            </article>
        @empty
            <p class="bookmarks-page__empty">Aún no has enviado postulaciones.</p>
        @endforelse
    </section>
</main>
@endsection
