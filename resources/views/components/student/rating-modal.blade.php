@props([
    'company',
])

<div
    class="rating-modal__overlay"
    data-rating-modal
    hidden
>

    <form
        class="rating-modal"
        data-rating-form
    >

        <div class="rating-modal__body">

            <div class="rating-modal__content">

                <header class="rating-modal__header">

                    <div class="rating-modal__company">

                        @if ($company['logo'])

                            <img
                                src="{{ $company['logo'] }}"
                                alt="Logo de {{ $company['name'] }}"
                                class="rating-modal__company-logo"
                            >

                        @else

                            <div class="
                                rating-modal__company-logo
                                rating-modal__company-logo--empty
                            "></div>

                        @endif


                        <h2 class="rating-modal__title">
                            Evaluación a {{ $company['name'] }}
                        </h2>

                    </div>


                    <p class="rating-modal__intro">
                        Comparte con el mundo tu experiencia laboral y sé la guía
                        de miles de estudiantes interesados en unirse a la empresa.
                    </p>

                </header>


                <div class="rating-modal__fields">

                    {{-- PUESTO --}}

                    <div class="rating-modal__field">

                        <label
                            for="rating-position"
                            class="rating-modal__label"
                        >
                            Tu puesto en {{ $company['name'] }}
                        </label>

                        <input
                            id="rating-position"
                            type="text"
                            name="position"
                            class="rating-modal__input"
                            required
                        >

                    </div>


                    {{-- CALIFICACIÓN --}}

                    <div class="rating-modal__field">

                        <span class="rating-modal__label">
                            Calificación de la experiencia laboral
                        </span>

                        <input
                            type="hidden"
                            name="rating"
                            value="0"
                            data-rating-value
                        >

                        <div class="rating-modal__stars">

                            @for ($star = 1; $star <= 5; $star++)

                                <button
                                    type="button"
                                    class="rating-modal__star-button"
                                    aria-label="Calificar con {{ $star }} estrellas"
                                    data-rating-star="{{ $star }}"
                                >

                                    <img
                                        src="{{ asset('images/Starnofill.svg') }}"
                                        alt=""
                                        class="rating-modal__star"
                                    >

                                </button>

                            @endfor

                        </div>

                    </div>


                    {{-- DESCRIPCIÓN --}}

                    <div class="rating-modal__field">

                        <label
                            for="rating-description"
                            class="rating-modal__label"
                        >
                            Descripción de la evaluación
                        </label>

                        <textarea
                            id="rating-description"
                            name="description"
                            class="
                                rating-modal__input
                                rating-modal__textarea
                            "
                            required
                        ></textarea>

                    </div>


                    {{-- FECHAS --}}

                    <div class="rating-modal__dates">

                        <div class="rating-modal__date-field">

                            <label
                                for="rating-start-date"
                                class="rating-modal__label"
                            >
                                Fecha de inicio
                            </label>

                            <label class="rating-modal__date-control">

                                <span
                                    class="
                                        rating-modal__date-text
                                        rating-modal__date-text--empty
                                    "
                                    data-rating-date-text="start_date"
                                >
                                    DD/MM/AAAA
                                </span>

                                <img
                                    src="{{ asset('images/Calendar.svg') }}"
                                    alt=""
                                    class="rating-modal__calendar-icon"
                                >

                                <input
                                    id="rating-start-date"
                                    type="date"
                                    name="start_date"
                                    class="rating-modal__native-date"
                                    data-rating-date
                                    required
                                >

                            </label>

                        </div>


                        <div class="rating-modal__date-field">

                            <label
                                for="rating-end-date"
                                class="rating-modal__label"
                            >
                                Fecha de finalización
                            </label>

                            <label class="rating-modal__date-control">

                                <span
                                    class="
                                        rating-modal__date-text
                                        rating-modal__date-text--empty
                                    "
                                    data-rating-date-text="end_date"
                                >
                                    DD/MM/AAAA
                                </span>

                                <img
                                    src="{{ asset('images/Calendar.svg') }}"
                                    alt=""
                                    class="rating-modal__calendar-icon"
                                >

                                <input
                                    id="rating-end-date"
                                    type="date"
                                    name="end_date"
                                    class="rating-modal__native-date"
                                    data-rating-date
                                    data-rating-end-date
                                    required
                                >

                            </label>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <footer class="rating-modal__footer">

            <div class="rating-modal__actions">

                <button
                    type="button"
                    class="rating-modal__cancel"
                    data-rating-close
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="rating-modal__submit"
                >
                    Enviar
                </button>

            </div>

        </footer>

    </form>

</div>