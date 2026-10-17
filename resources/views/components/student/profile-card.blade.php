@props(['student'])

<aside
    class="student-profile-card"
    data-student-profile-card
    data-initial-editing="{{ $errors->any() ? 'true' : 'false' }}"
    aria-label="Datos de la cuenta estudiantil"
>

    <div
        class="student-profile-card__background"
        data-profile-background
    ></div>


    <form
        class="student-profile-card__content"
        method="POST"
        action="{{ route('student.profile.update') }}"
        enctype="multipart/form-data"
        data-profile-form
    >
        @csrf


        {{-- Identidad --}}
        <div class="student-profile-card__identity">

            <div
                class="student-profile-card__avatar-wrapper"
                data-profile-avatar-wrapper
            >

                <div
                    class="student-profile-card__avatar-container"
                    data-profile-avatar-container
                >

                    @if($student['avatar'] ?? null)

                        <img
                            src="{{ $student['avatar'] }}"
                            alt="Foto del perfil"
                            class="student-profile-card__avatar"
                            data-profile-avatar-image
                        >

                    @else

                        <div
                            class="
                                student-profile-card__avatar
                                student-profile-card__avatar--empty
                            "
                            data-profile-avatar-empty
                        >

                            <img
                                src="{{ asset('images/User.svg') }}"
                                alt=""
                                class="student-profile-card__avatar-placeholder"
                            >

                        </div>

                    @endif


                    <label
                        for="student-profile-avatar"
                        class="student-profile-card__avatar-overlay"
                        data-profile-avatar-overlay
                    >
                        <span>
                            Cambiar foto
                        </span>
                    </label>


                    <input
                        id="student-profile-avatar"
                        type="file"
                        name="avatar"
                        accept="image/jpeg,image/png,image/webp"
                        class="student-profile-card__avatar-input"
                        data-profile-avatar-input
                        data-profile-file
                    >

                </div>

            </div>


            <div class="student-profile-card__name">

                {{-- Nombre visible --}}
                <div data-profile-view-name>

                    <p>
                        {{ $student['firstName'] }}
                    </p>

                    <p>
                        {{ $student['paternalSurname'] }}
                    </p>

                    <p>
                        {{ $student['maternalSurname'] }}
                    </p>

                </div>


                {{-- Nombre editable --}}
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
                            maxlength="100"
                            class="student-profile-card__edit-input"
                            value="{{ old('first_name', $student['firstName']) }}"
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
                            name="paternal_last_name"
                            maxlength="100"
                            class="student-profile-card__edit-input"
                            value="{{ old('paternal_last_name', $student['paternalSurname']) }}"
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
                            name="maternal_last_name"
                            maxlength="100"
                            class="student-profile-card__edit-input"
                            value="{{ old('maternal_last_name', $student['maternalSurname']) }}"
                            data-profile-input="maternalSurname"
                            required
                        >

                    </div>

                </div>

            </div>

        </div>


        {{-- Información --}}
        <div class="student-profile-card__information">


            {{-- Información visible --}}
            <div data-profile-view-info>

                <div class="student-profile-card__info-row">

                    <img
                        src="{{ asset('images/Mail.svg') }}"
                        alt=""
                        class="student-profile-card__info-icon"
                    >

                    <span title="{{ $student['email'] }}">
                        {{ $student['email'] }}
                    </span>

                </div>


                <div class="student-profile-card__info-row">

                    <img
                        src="{{ asset('images/Phone.svg') }}"
                        alt=""
                        class="student-profile-card__info-icon"
                    >

                    <span title="{{ $student['phone'] }}">
                        {{ $student['phone'] }}
                    </span>

                </div>


                <div class="student-profile-card__info-row">

                    <img
                        src="{{ asset('images/Calendarprofile.svg') }}"
                        alt=""
                        class="student-profile-card__info-icon"
                    >

                    <span title="{{ $student['birthDate'] }}">
                        {{ $student['birthDate'] }}
                    </span>

                </div>


                {{-- Kardex --}}
                @if($student['hasKardex'] ?? false)

                    <a
                        href="{{ route('student.profile.kardex') }}"
                        class="student-profile-card__document"
                    >

                        <img
                            src="{{ asset('images/File.svg') }}"
                            alt=""
                            class="student-profile-card__document-icon"
                        >

                        <span>
                            Kardex
                        </span>

                    </a>

                @else

                    <div class="
                        student-profile-card__document
                        student-profile-card__document--disabled
                    ">

                        <img
                            src="{{ asset('images/File.svg') }}"
                            alt=""
                            class="student-profile-card__document-icon"
                        >

                        <span>
                            Kardex no disponible
                        </span>

                    </div>

                @endif


                {{-- CV --}}
                @if($student['hasCv'] ?? false)

                    <a
                        href="{{ route('student.profile.cv') }}"
                        class="student-profile-card__document"
                    >

                        <img
                            src="{{ asset('images/File.svg') }}"
                            alt=""
                            class="student-profile-card__document-icon"
                        >

                        <span>
                            CV
                        </span>

                    </a>

                @else

                    <div class="
                        student-profile-card__document
                        student-profile-card__document--disabled
                    ">

                        <img
                            src="{{ asset('images/File.svg') }}"
                            alt=""
                            class="student-profile-card__document-icon"
                        >

                        <span>
                            CV no disponible
                        </span>

                    </div>

                @endif

            </div>


            {{-- Información editable --}}
            <div
                data-profile-edit-info
                hidden
            >

                {{-- Correo --}}
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


                {{-- Teléfono --}}
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
                        minlength="10"
                        maxlength="10"
                        pattern="[0-9]{10}"
                        inputmode="numeric"
                        class="student-profile-card__edit-input"
                        value="{{ old('phone', $student['phone']) }}"
                        data-profile-input="phone"
                        required
                    >

                </div>


                {{-- Fecha de nacimiento --}}
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
                            value="{{ old('birth_date', $student['birthDateValue']) }}"
                            data-profile-input="birthDate"
                            required
                        >

                    </div>

                </div>


                {{-- Nueva contraseña --}}
                <div class="student-profile-card__edit-field">

                    <label
                        for="student-profile-password"
                        class="student-profile-card__edit-label"
                    >
                        Nueva contraseña
                    </label>

                    <input
                        id="student-profile-password"
                        type="password"
                        name="password"
                        minlength="8"
                        maxlength="72"
                        class="student-profile-card__edit-input"
                        autocomplete="new-password"
                        data-profile-password
                    >

                </div>


                {{-- Confirmar contraseña --}}
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
                        minlength="8"
                        maxlength="72"
                        class="student-profile-card__edit-input"
                        autocomplete="new-password"
                        data-profile-password-confirmation
                    >

                </div>


                {{-- Kardex --}}
                <div class="student-profile-card__edit-field">

                    <label
                        for="student-profile-kardex"
                        class="student-profile-card__edit-label"
                    >
                        Kardex
                    </label>

                    <input
                        id="student-profile-kardex"
                        type="file"
                        name="kardex"
                        accept=".pdf,application/pdf"
                        class="student-profile-card__edit-file"
                        data-profile-file
                    >

                </div>


                {{-- CV --}}
                <div class="student-profile-card__edit-field">

                    <label
                        for="student-profile-cv"
                        class="student-profile-card__edit-label"
                    >
                        CV
                    </label>

                    <input
                        id="student-profile-cv"
                        type="file"
                        name="cv"
                        accept=".pdf,application/pdf"
                        class="student-profile-card__edit-file"
                        data-profile-file
                    >

                </div>

            </div>

        </div>


        {{-- Editar --}}
        <button
            type="button"
            class="student-profile-card__edit"
            data-profile-edit
        >
            Editar datos
        </button>


        {{-- Acciones de edición --}}
        <div
            class="student-profile-card__edit-actions"
            data-profile-edit-actions
            hidden
        >

            <button
                type="submit"
                class="student-profile-card__confirm"
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

    </form>

</aside>