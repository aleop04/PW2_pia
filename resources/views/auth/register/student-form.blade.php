<div class="student-register">

    <div class="student-register__slider">

        <!-- =========================================
             DATOS PARA CREAR LA CUENTA
        ========================================== -->
        <div
            class="student-register__step"
            data-student-step="data"
        >

            <div class="student-register__content">

                <!-- Encabezado -->
                <div class="student-register__header">

                    <button
                        type="button"
                        class="student-register__back"
                        aria-label="Regresar"
                        data-student-back-account
                    >
                        <img
                            src="{{ asset('images/Arrowleft-circle.svg') }}"
                            alt=""
                            class="student-register__back-icon"
                        >
                    </button>


                    <h1 class="student-register__title">
                        Escribe los datos correspondientes
                    </h1>

                </div>


                <!-- Formulario -->
                <form
                    class="student-register__form"
                    data-student-form
                    method="POST"
                    action="{{ route('register.student') }}"
                >
                    @csrf
                    <input type="hidden" name="_account_type" value="student">
                    @if ($selectedType === 'student')
                        @include('components.auth-feedback')
                    @endif

                    <!-- Nombre -->
                    <div class="student-register__field">

                        <label
                            for="student-first-name"
                            class="student-register__label"
                        >
                            Nombre/s
                        </label>

                        <input
                            id="student-first-name"
                            name="first_name"
                            maxlength="100"
                            value="{{ old('first_name') }}"
                            type="text"
                            class="student-register__input"
                            autocomplete="given-name"
                            required
                        >

                    </div>


                    <!-- Apellido paterno -->
                    <div class="student-register__field">

                        <label
                            for="student-paternal-surname"
                            class="student-register__label"
                        >
                            Apellido paterno
                        </label>

                        <input
                            id="student-paternal-surname"
                            name="paternal_last_name"
                            maxlength="100"
                            value="{{ old('paternal_last_name') }}"
                            type="text"
                            class="student-register__input"
                            autocomplete="family-name"
                            required
                        >

                    </div>


                    <!-- Apellido materno -->
                    <div class="student-register__field">

                        <label
                            for="student-maternal-surname"
                            class="student-register__label"
                        >
                            Apellido materno
                        </label>

                        <input
                            id="student-maternal-surname"
                            name="maternal_last_name"
                            maxlength="100"
                            value="{{ old('maternal_last_name') }}"
                            type="text"
                            class="student-register__input"
                            required
                        >

                    </div>


                    <!-- Fecha + teléfono -->
                    <div class="student-register__row">

                        <!-- Fecha -->
                        <div class="
                            student-register__field
                            student-register__field--date
                        ">

                            <label
                                for="student-birth-date"
                                class="student-register__label"
                            >
                                Fecha de nacimiento
                            </label>


                            <div class="student-register__date-wrapper">

                                <input
                                    id="student-birth-date"
                                    name="birth_date"
                                    value="{{ old('birth_date') }}"
                                    type="date"
                                    class="
                                        student-register__input
                                        student-register__date-input
                                    "
                                    required
                                >

                                <img
                                    src="{{ asset('images/Calendar.svg') }}"
                                    alt=""
                                    class="student-register__calendar-icon"
                                >

                            </div>

                        </div>


                        <!-- Teléfono -->
                        <div class="
                            student-register__field
                            student-register__field--phone
                        ">

                            <label
                                for="student-phone"
                                class="student-register__label"
                            >
                                Número de teléfono
                            </label>

                            <input
                                id="student-phone"
                                name="phone"
                                pattern="[0-9]{10}"
                                minlength="10"
                                maxlength="10"
                                inputmode="numeric"
                                aria-describedby="student-phone-help"
                                value="{{ old('phone') }}"
                                type="tel"
                                class="student-register__input"
                                autocomplete="tel"
                                required
                            >

                            <small id="student-phone-help" class="auth-field-hint">10 dígitos de México, sin espacios ni +52.</small>

                        </div>

                    </div>


                    <!-- Correo -->
                    <div class="student-register__field">

                        <label
                            for="student-email"
                            class="student-register__label"
                        >
                            Correo electrónico
                        </label>

                        <input
                            id="student-email"
                            name="email"
                            maxlength="255"
                            value="{{ old('email') }}"
                            type="email"
                            class="student-register__input"
                            autocomplete="email"
                            required
                        >

                    </div>


                    <!-- Contraseña -->
                    <div class="student-register__field">

                        <label
                            for="student-password"
                            class="student-register__label"
                        >
                            Contraseña
                        </label>

                        <input
                            id="student-password"
                            name="password"
                            minlength="8"
                            maxlength="72"
                            type="password"
                            class="student-register__input"
                            autocomplete="new-password"
                            aria-describedby="student-password-help"
                            required
                        >

                        <small id="student-password-help" class="auth-field-hint">Usa al menos 8 caracteres, una mayúscula y un número.</small>
                        <button type="button" class="auth-password-toggle" data-password-toggle="student-password" aria-label="Mostrar contraseña">Ver contraseña</button>

                    </div>


                    <!-- Confirmar contraseña -->
                    <div class="student-register__field">

                        <label
                            for="student-password-confirmation"
                            class="student-register__label"
                        >
                            Confirmar contraseña
                        </label>

                        <input
                            id="student-password-confirmation"
                            name="password_confirmation"
                            minlength="8"
                            maxlength="72"
                            type="password"
                            class="student-register__input"
                            autocomplete="new-password"
                            required
                        >
                        <button type="button" class="auth-password-toggle" data-password-toggle="student-password-confirmation" aria-label="Mostrar confirmación de contraseña">Ver contraseña</button>

                    </div>


                    <button
                        type="submit"
                        class="student-register__confirm"
                    >
                        Crear cuenta
                    </button>

                </form>

            </div>

        </div>


    </div>

</div>
