@props([
    'student',
])

<aside
    class="student-profile-card"
    data-student-profile-card
>

    {{-- FONDO --}}

    <div
        class="student-profile-card__background"
        data-profile-background
    ></div>


    {{-- CONTENIDO --}}

    <div class="student-profile-card__content">

        {{--  AVATAR + NOMBRE  --}}

        <div class="student-profile-card__identity">

            <div class="student-profile-card__avatar-wrapper">

                @if (!empty($student['avatar']))

                    <img
                        src="{{ $student['avatar'] }}"
                        alt="Foto de perfil"
                        class="student-profile-card__avatar"
                    >

                @else

                    <div class="
                        student-profile-card__avatar
                        student-profile-card__avatar--empty
                    ">

                        <img
                            src="{{ asset('images/User.svg') }}"
                            alt=""
                            class="student-profile-card__avatar-placeholder"
                        >

                    </div>

                @endif

            </div>


            <div class="student-profile-card__name">

                {{-- MODO NORMAL --}}

                <div data-profile-view-name>

                    <p data-profile-first-name>
                        {{ $student['firstName'] }}
                    </p>

                    <p data-profile-paternal-surname>
                        {{ $student['paternalSurname'] }}
                    </p>

                    <p data-profile-maternal-surname>
                        {{ $student['maternalSurname'] }}
                    </p>

                </div>


                {{-- MODO EDICIÓN --}}

                <div
                    data-profile-edit-name
                    hidden
                >

                    <div class="student-profile-card__edit-field">

                        <label
                            for="student-profile-first-name"
                            class="student-profile-card__edit-label"
                        >
                            Nombre
                        </label>

                        <input
                            id="student-profile-first-name"
                            type="text"
                            name="first_name"
                            class="student-profile-card__edit-input"
                            value="{{ $student['firstName'] }}"
                            data-profile-input="firstName"
                            required
                        >

                    </div>


                    <div class="student-profile-card__edit-field">

                        <label
                            for="student-profile-paternal-surname"
                            class="student-profile-card__edit-label"
                        >
                            Apellido paterno
                        </label>

                        <input
                            id="student-profile-paternal-surname"
                            type="text"
                            name="paternal_surname"
                            class="student-profile-card__edit-input"
                            value="{{ $student['paternalSurname'] }}"
                            data-profile-input="paternalSurname"
                            required
                        >

                    </div>


                    <div class="student-profile-card__edit-field">

                        <label
                            for="student-profile-maternal-surname"
                            class="student-profile-card__edit-label"
                        >
                            Apellido materno
                        </label>

                        <input
                            id="student-profile-maternal-surname"
                            type="text"
                            name="maternal_surname"
                            class="student-profile-card__edit-input"
                            value="{{ $student['maternalSurname'] }}"
                            data-profile-input="maternalSurname"
                            required
                        >

                    </div>

                </div>

            </div>

        </div>


        {{--  INFORMACIÓN  --}}

        <div class="student-profile-card__information">

            {{-- MODO NORMAL --}}

            <div data-profile-view-info>

                <div class="student-profile-card__info-row">

                    <img
                        src="{{ asset('images/Mail.svg') }}"
                        alt=""
                        class="student-profile-card__info-icon"
                    >

                    <span data-profile-email>
                        {{ $student['email'] }}
                    </span>

                </div>


                <div class="student-profile-card__info-row">

                    <img
                        src="{{ asset('images/Phone.svg') }}"
                        alt=""
                        class="student-profile-card__info-icon"
                    >

                    <span data-profile-phone>
                        {{ $student['phone'] }}
                    </span>

                </div>


                <div class="student-profile-card__info-row">

                    <img
                        src="{{ asset('images/Mappin.svg') }}"
                        alt=""
                        class="student-profile-card__info-icon"
                    >

                    <span data-profile-location>
                        {{ $student['location'] }}
                    </span>

                </div>


                <div class="student-profile-card__info-row">

                    <img
                        src="{{ asset('images/Calendarprofile.svg') }}"
                        alt=""
                        class="student-profile-card__info-icon"
                    >

                    <span data-profile-birth-date>
                        {{ $student['birthDate'] }}
                    </span>

                </div>

            </div>


            {{-- MODO EDICIÓN --}}

            <div
                data-profile-edit-info
                hidden
            >

                <div class="student-profile-card__edit-field">

                    <label
                        for="student-profile-email"
                        class="student-profile-card__edit-label"
                    >
                        Correo
                    </label>

                    <input
                        id="student-profile-email"
                        type="email"
                        class="
                            student-profile-card__edit-input
                            student-profile-card__edit-input--readonly
                        "
                        value="{{ $student['email'] }}"
                        readonly
                    >

                </div>


                <div class="student-profile-card__edit-field">

                    <label
                        for="student-profile-phone"
                        class="student-profile-card__edit-label"
                    >
                        Teléfono
                    </label>

                    <input
                        id="student-profile-phone"
                        type="tel"
                        name="phone"
                        class="student-profile-card__edit-input"
                        value="{{ $student['phone'] }}"
                        data-profile-input="phone"
                        required
                    >

                </div>


                <div class="student-profile-card__edit-field">

                    <label
                        for="student-profile-location"
                        class="student-profile-card__edit-label"
                    >
                        Ubicación
                    </label>

                    <input
                        id="student-profile-location"
                        type="text"
                        name="location"
                        class="student-profile-card__edit-input"
                        value="{{ $student['location'] }}"
                        data-profile-input="location"
                    >

                </div>


                <div class="student-profile-card__birth-date-edit">

                    <label
                        for="student-profile-birth-date"
                        class="student-profile-card__edit-label"
                    >
                        Fecha de nacimiento
                    </label>

                    <div class="student-profile-card__birth-date-control">

                        <input
                            id="student-profile-birth-date"
                            type="date"
                            name="birth_date"
                            class="
                                student-profile-card__edit-input
                                student-profile-card__date-input
                            "
                            value="{{ $student['birthDateValue'] }}"
                            data-profile-input="birthDate"
                            required
                        >

                    </div>

                </div>


                <div class="student-profile-card__edit-field">

                    <label
                        for="student-profile-password"
                        class="student-profile-card__edit-label"
                    >
                        Contraseña
                    </label>

                    <input
                        id="student-profile-password"
                        type="password"
                        name="password"
                        class="student-profile-card__edit-input"
                        autocomplete="new-password"
                        data-profile-password
                    >

                </div>


                <div class="student-profile-card__edit-field">

                    <label
                        for="student-profile-password-confirmation"
                        class="student-profile-card__edit-label"
                    >
                        Confirmar contraseña
                    </label>

                    <input
                        id="student-profile-password-confirmation"
                        type="password"
                        name="password_confirmation"
                        class="student-profile-card__edit-input"
                        autocomplete="new-password"
                        data-profile-password-confirmation
                    >

                </div>

            </div>


            {{-- KARDEX --}}

            <button
                type="button"
                class="student-profile-card__document"
                data-profile-kardex
            >

                <img
                    src="{{ asset('images/File.svg') }}"
                    alt=""
                    class="student-profile-card__document-icon"
                >

                <span>Kardex</span>

            </button>


            {{-- CV --}}

            <button
                type="button"
                class="student-profile-card__document"
                data-profile-cv
            >

                <img
                    src="{{ asset('images/File.svg') }}"
                    alt=""
                    class="student-profile-card__document-icon"
                >

                <span>CV</span>

            </button>

        </div>


        {{--  ACCIONES  --}}

        <button
            type="button"
            class="student-profile-card__edit"
            data-profile-edit
        >
            Editar datos
        </button>


        <div
            class="student-profile-card__edit-actions"
            data-profile-edit-actions
            hidden
        >

            <button
                type="button"
                class="student-profile-card__confirm"
                data-profile-confirm
            >
                Confirmar
            </button>

            <button
                type="button"
                class="student-profile-card__cancel"
                data-profile-cancel
            >
                Cancelar
            </button>

        </div>

    </div>

</aside>