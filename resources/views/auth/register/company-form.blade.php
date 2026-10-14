<div class="company-register">

    <div class="company-register__content">

        <!-- Encabezado -->
        <div class="company-register__header">

            <button
                type="button"
                class="student-register__back"
                aria-label="Regresar"
                data-company-back
            >
                <img
                    src="{{ asset('images/Arrowleft-circle.svg') }}"
                    alt=""
                    class="student-register__back-icon"
                >
            </button>

            <h1 class="company-register__title">
                Escribe los datos correspondientes
            </h1>

        </div>


        <!-- Formulario -->
        <form
            class="company-register__form"
            data-company-form
            method="POST"
            action="{{ route('register.company') }}"
        >
            @csrf
            <input type="hidden" name="_account_type" value="company">
            @if ($selectedType === 'company')
                @include('components.auth-feedback')
            @endif

            <!-- Nombre de empresa -->
            <div class="company-register__field">

                <label
                    for="company-name"
                    class="company-register__label"
                >
                    Nombre de la empresa
                </label>

                <input
                    id="company-name"
                    name="company_name"
                    maxlength="150"
                    value="{{ old('company_name') }}"
                    type="text"
                    class="company-register__input"
                    autocomplete="organization"
                    required
                >

            </div>


            <!-- RFC -->
            <div class="company-register__field">

                <label
                    for="company-rfc"
                    class="company-register__label"
                >
                    RFC
                </label>

                <input
                    id="company-rfc"
                    name="rfc"
                    maxlength="12"
                    minlength="12"
                    pattern="[A-Za-zÑñ&]{3}[0-9]{6}[A-Za-z0-9]{3}"
                    value="{{ old('rfc') }}"
                    type="text"
                    class="company-register__input"
                    aria-describedby="company-rfc-help"
                    required
                >

                <small id="company-rfc-help" class="auth-field-hint">12 caracteres. Ejemplo: ABC010203AB1.</small>

            </div>


            <!-- Sector -->
            <div class="company-register__field">

                <label class="company-register__label">
                    Sector
                </label>


                <div
                    class="company-register__sector-dropdown"
                    data-sector-dropdown
                >

                    <!-- Valor real del sector -->
                    <input
                        type="hidden"
                        name="sector"
                        value="{{ old('sector') }}"
                        data-sector-input
                    >


                    <!-- Caja principal -->
                    <button
                        type="button"
                        class="company-register__sector-trigger"
                        data-sector-trigger
                        aria-expanded="false"
                    >

                        <span
                            class="company-register__sector-placeholder"
                            data-sector-label
                        >
                            Selecciona un sector
                        </span>

                        <img
                            src="{{ asset('images/Chevrondown.svg') }}"
                            alt=""
                            class="company-register__select-icon"
                            data-sector-icon
                        >

                    </button>


                    <!-- Opciones creadas desde register.js -->
                    <div
                        class="company-register__sector-menu"
                        data-sector-menu
                        hidden
                    ></div>

                </div>


                <!-- Campo adicional si selecciona "Otro" -->
                <input
                    type="text"
                    name="custom_sector"
                    maxlength="100"
                    value="{{ old('custom_sector') }}"
                    class="
                        company-register__input
                        company-register__custom-sector
                    "
                    placeholder="Escribe el sector"
                    data-custom-sector
                    hidden
                >

            </div>


            <!-- Estado + Ciudad -->
            <div class="company-register__row">

                <!-- Estado -->
                <div class="
                    company-register__field
                    company-register__field--state
                ">

                    <label
                        for="company-state"
                        class="company-register__label"
                    >
                        Estado
                    </label>

                    <input
                        id="company-state"
                        name="state"
                        maxlength="100"
                        value="{{ old('state') }}"
                        type="text"
                        class="company-register__input"
                        autocomplete="address-level1"
                        required
                    >

                </div>


                <!-- Ciudad -->
                <div class="
                    company-register__field
                    company-register__field--city
                ">

                    <label
                        for="company-city"
                        class="company-register__label"
                    >
                        Ciudad
                    </label>

                    <input
                        id="company-city"
                        name="city"
                        maxlength="100"
                        value="{{ old('city') }}"
                        type="text"
                        class="company-register__input"
                        autocomplete="address-level2"
                        required
                    >

                </div>

            </div>


            <!-- Correo -->
            <div class="company-register__field">

                <label
                    for="company-email"
                    class="company-register__label"
                >
                    Correo electrónico
                </label>

                <input
                    id="company-email"
                    name="email"
                    maxlength="255"
                    value="{{ old('email') }}"
                    type="email"
                    class="company-register__input"
                    autocomplete="email"
                    required
                >

            </div>


            <!-- Contraseña -->
            <div class="company-register__field">

                <label
                    for="company-password"
                    class="company-register__label"
                >
                    Contraseña
                </label>

                <input
                    id="company-password"
                    name="password"
                    minlength="8"
                    maxlength="72"
                    type="password"
                    class="company-register__input"
                    autocomplete="new-password"
                    aria-describedby="company-password-help"
                    required
                >

                <small id="company-password-help" class="auth-field-hint">Usa al menos 8 caracteres, una mayúscula y un número.</small>
                <button type="button" class="auth-password-toggle" data-password-toggle="company-password" aria-label="Mostrar contraseña">Ver contraseña</button>

            </div>


            <!-- Confirmar contraseña -->
            <div class="company-register__field">

                <label
                    for="company-password-confirmation"
                    class="company-register__label"
                >
                    Confirmar contraseña
                </label>

                <input
                    id="company-password-confirmation"
                    name="password_confirmation"
                    minlength="8"
                    maxlength="72"
                    type="password"
                    class="company-register__input"
                    autocomplete="new-password"
                    required
                >
                <button type="button" class="auth-password-toggle" data-password-toggle="company-password-confirmation" aria-label="Mostrar confirmación de contraseña">Ver contraseña</button>

            </div>


            <!-- Confirmar -->
            <button
                type="submit"
                class="
                    student-register__confirm
                    company-register__confirm
                "
            >
                Crear cuenta
            </button>

            <p class="auth-feedback auth-feedback--error" data-sector-error role="alert" hidden>
                Selecciona un sector antes de crear la cuenta.
            </p>
        </form>

    </div>

</div>
