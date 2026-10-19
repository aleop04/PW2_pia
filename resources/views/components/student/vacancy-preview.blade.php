@props([
    'vacancy',
])

<article
    class="vacancy-preview"
    data-vacancy-preview
    data-vacancy-id="{{ $vacancy['id'] }}"
>

    {{--  ENCABEZADO  --}}

    <header class="vacancy-preview__header">

        <div class="vacancy-preview__header-content">

            <div class="vacancy-preview__main-info">

                <a
                    href="{{ route('student.vacancies.show', ['id' => $vacancy['id']]) }}"
                    class="vacancy-preview__title"
                    data-preview-title
                >
                    {{ $vacancy['title'] }}
                </a>


                <div class="vacancy-preview__meta">

                    <a
                        href="{{ route('student.companies.show', [
                            'id' => $vacancy['companyId']
                        ]) }}"
                        class="vacancy-preview__company"
                        data-preview-company
                    >
                        {{ $vacancy['company'] }}
                    </a>

                    <span data-preview-location>
                        {{ $vacancy['location'] }}
                    </span>

                    <span data-preview-salary-modality>
                        {{ $vacancy['salary'] }} - {{ $vacancy['modality'] }}
                    </span>

                </div>

            </div>

            <x-student.bookmark-form :id="$vacancy['id']" :saved="$vacancy['saved'] ?? false" />

        </div>

    </header>


    {{--  CUERPO  --}}

    <div class="vacancy-preview__body">

        {{--  INFORMACIÓN DE EMPLEO  --}}

        <section class="vacancy-preview__employment">

            <h2 class="vacancy-preview__section-title">
                Información de empleo
            </h2>


            <div class="vacancy-preview__employment-content">

                {{-- DURACIÓN --}}

                <div class="vacancy-preview__employment-row">

                    <div class="vacancy-preview__employment-label">

                        <img
                            src="{{ asset('images/Clock.svg') }}"
                            alt=""
                            class="vacancy-preview__employment-icon"
                        >

                        <span>
                            Duración de estadía
                        </span>

                    </div>

                    <span
                        class="vacancy-preview__employment-value"
                        data-preview-duration
                    >
                        {{ $vacancy['stayDuration'] }}
                    </span>

                </div>


                {{-- PRESTACIONES --}}

                <div class="
                    vacancy-preview__employment-row
                    vacancy-preview__employment-row--benefits
                ">

                    <div class="vacancy-preview__employment-label">

                        <img
                            src="{{ asset('images/Gift.svg') }}"
                            alt=""
                            class="vacancy-preview__employment-icon"
                        >

                        <span>
                            Prestaciones
                        </span>

                    </div>


                    <div
                        class="vacancy-preview__benefits"
                        data-preview-benefits
                    >

                        @foreach ($vacancy['benefits'] as $benefit)

                            <span class="vacancy-preview__benefit">
                                {{ $benefit }}
                            </span>

                        @endforeach

                    </div>

                </div>


                {{-- TIPO DE PUESTO --}}

                <div class="vacancy-preview__employment-row">

                    <div class="vacancy-preview__employment-label">

                        <img
                            src="{{ asset('images/Briefcase.svg') }}"
                            alt=""
                            class="vacancy-preview__employment-icon"
                        >

                        <span>
                            Tipo de puesto
                        </span>

                    </div>

                    <span
                        class="vacancy-preview__employment-value"
                        data-preview-job-type
                    >
                        {{ $vacancy['jobType'] }}
                    </span>

                </div>

            </div>

        </section>


        {{--  DESCRIPCIÓN  --}}

        <section class="vacancy-preview__description">

            <h2 class="vacancy-preview__section-title">
                Descripción de la vacante
            </h2>

            <p
                class="vacancy-preview__description-text"
                data-preview-description
            >
                {{ $vacancy['description'] }}
            </p>

        </section>

        <div class="vacancy-preview__actions">
            <button type="button" class="vacancy-detail__primary-button" data-application-open data-preview-apply
               @if($vacancy['applied'] ?? false) hidden @endif>Postularse</button>
            <span class="flow-feedback flow-feedback--success" data-preview-applied
                  @unless($vacancy['applied'] ?? false) hidden @endunless>Postulación enviada</span>
        </div>

    </div>

</article>
