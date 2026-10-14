@extends('layouts.student')

@section('content')

<main
    class="company-public-profile"
    data-company-public-profile
>

    <script
        type="application/json"
        data-reviews-json
    >@json($reviews)</script>


    {{-- PARTE SUPERIOR --}}

    <section class="company-public-profile__top">

        <div class="company-public-profile__header">

            <div class="company-public-profile__identity">

                @if ($company['logo'])

                    <img
                        src="{{ $company['logo'] }}"
                        alt="Logo de {{ $company['name'] }}"
                        class="company-public-profile__logo"
                    >

                @else

                    <div class="
                        company-public-profile__logo
                        company-public-profile__logo--empty
                    "></div>

                @endif


                <div class="company-public-profile__identity-info">

                    <h1 class="company-public-profile__name">
                        {{ $company['name'] }}
                    </h1>


                    <div class="company-public-profile__meta">

                        <span class="company-public-profile__sector">
                            {{ $company['sector'] }}
                        </span>

                    </div>

                </div>

            </div>



        </div>


        {{-- DESCRIPCIÓN --}}

        <section class="company-public-profile__description">

            <h2 class="company-public-profile__section-title">
                Descripción de la empresa
            </h2>

            <p class="company-public-profile__description-text">
                {{ $company['description'] }}
            </p>

        </section>

    </section>


    {{-- PESTAÑAS --}}

    <div class="company-public-profile__tabs">

        <button
            type="button"
            class="company-public-profile__tab company-public-profile__tab--active"
            data-profile-tab="vacancies"
        >
            Vacantes disponibles
        </button>

    </div>


    {{--  VACANTES  --}}

    <section
        class="company-public-profile__vacancies"
        data-profile-section="vacancies"
    >

        @foreach ($vacancies as $vacancy)

            <x-vacancy-card
                :vacancy="$vacancy"
                :href="route('student.vacancies.show', [
                    'id' => $vacancy['id']
                ])"
            />

        @endforeach

    </section>


</main>

@endsection
