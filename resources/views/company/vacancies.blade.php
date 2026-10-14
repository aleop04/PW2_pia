@extends('layouts.company-dashboard')

@section('dashboard-content')

<section class="company-vacancies">

    {{-- ========================================
         TITLE
    ========================================= --}}

    <h1 class="company-vacancies__title">
        Vacantes publicadas
    </h1>


    {{-- ========================================
         VACANCIES GRID
    ========================================= --}}

    <div class="company-vacancies__grid">

        @forelse ($vacancies as $vacancy)

            <x-vacancy-card
                :vacancy="$vacancy"
                variant="company"
                :href="route(
                    'company.vacancies.show',
                    ['id' => $vacancy['id']]
                )"
            />

        @empty
            <p>Aún no has publicado vacantes.</p>
        @endforelse

    </div>

</section>

@endsection