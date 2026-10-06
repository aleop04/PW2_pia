@props([
    'vacancy',
    'companyHref' => null,
])

<section class="vacancy-detail">

    {{--  INFORMACIÓN PRINCIPAL  --}}

    <div class="vacancy-detail__main">

        {{-- ENCABEZADO --}}

        <header class="vacancy-detail__header">

            <h1 class="vacancy-detail__title">
                {{ $vacancy['title'] }}
            </h1>

            <div class="vacancy-detail__meta">

                @if ($companyHref)

                    <a
                        href="{{ $companyHref }}"
                        class="vacancy-detail__company"
                    >
                        {{ $vacancy['company'] }}
                    </a>

                @else

                    <span class="vacancy-detail__company">
                        {{ $vacancy['company'] }}
                    </span>

                @endif

                <p class="vacancy-detail__meta-text">
                    {{ $vacancy['location'] }}
                </p>

                <p class="vacancy-detail__meta-text">
                    {{ $vacancy['salary'] }}
                    -
                    {{ $vacancy['modality'] }}
                </p>

            </div>

        </header>


        {{--  INFORMACIÓN DE EMPLEO  --}}

        <section class="vacancy-detail__employment">

            <h2 class="vacancy-detail__section-title">
                Información de empleo
            </h2>

            <div class="vacancy-detail__employment-content">

                {{-- DURACIÓN --}}

                <div class="vacancy-detail__employment-row">

                    <div class="vacancy-detail__employment-label">

                        <img
                            src="{{ asset('images/Clock.svg') }}"
                            alt=""
                            class="vacancy-detail__employment-icon"
                        >

                        <span>
                            Duración de estadía
                        </span>

                    </div>

                    <span class="vacancy-detail__employment-value">
                        {{ $vacancy['stayDuration'] }}
                    </span>

                </div>


                {{-- PRESTACIONES --}}

                <div class="
                    vacancy-detail__employment-row
                    vacancy-detail__employment-row--benefits
                ">

                    <div class="vacancy-detail__employment-label">

                        <img
                            src="{{ asset('images/Gift.svg') }}"
                            alt=""
                            class="vacancy-detail__employment-icon"
                        >

                        <span>
                            Prestaciones
                        </span>

                    </div>

                    <div class="vacancy-detail__benefits">

                        @foreach ($vacancy['benefits'] as $benefit)

                            <span class="vacancy-detail__benefit">
                                {{ $benefit }}
                            </span>

                        @endforeach

                    </div>

                </div>


                {{-- TIPO DE PUESTO --}}

                <div class="vacancy-detail__employment-row">

                    <div class="vacancy-detail__employment-label">

                        <img
                            src="{{ asset('images/Briefcase.svg') }}"
                            alt=""
                            class="vacancy-detail__employment-icon"
                        >

                        <span>
                            Tipo de puesto
                        </span>

                    </div>

                    <span class="vacancy-detail__employment-value">
                        {{ $vacancy['jobType'] }}
                    </span>

                </div>

            </div>

        </section>


        {{-- DESCRIPCIÓN  --}}

        <section class="vacancy-detail__description">

            <h2 class="vacancy-detail__section-title">
                Descripción de la vacante
            </h2>

            <p class="vacancy-detail__description-text">
                {{ $vacancy['description'] }}
            </p>

        </section>

    </div>


    {{--  ACCIONES  --}}

    <aside class="vacancy-detail__actions">

        {{ $actions ?? '' }}

    </aside>

</section>