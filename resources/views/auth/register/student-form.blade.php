<div class="student-register">

    <div class="student-register__slider">

        <!-- =========================================
             PASO 1 - DATOS PERSONALES
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
                >

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
                            name="paternal_surname"
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
                            name="maternal_surname"
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
                                type="tel"
                                class="student-register__input"
                                autocomplete="tel"
                                required
                            >

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
                            type="password"
                            class="student-register__input"
                            autocomplete="new-password"
                            required
                        >

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
                            type="password"
                            class="student-register__input"
                            autocomplete="new-password"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        class="student-register__confirm"
                    >
                        Confirmar
                    </button>

                </form>

            </div>

        </div>


        <!-- =========================================
             PASO 2 - KARDEX
        ========================================== -->
        <div
            class="student-register__step"
            data-student-step="kardex"
            hidden
        >

            <div class="student-register__verification">

                <!-- Encabezado -->
                <div class="student-register__verification-header">

                    <button
                        type="button"
                        class="student-register__back"
                        aria-label="Regresar a datos personales"
                        data-student-back-data
                    >
                        <img
                            src="{{ asset('images/Arrowleft-circle.svg') }}"
                            alt=""
                            class="student-register__back-icon"
                        >
                    </button>


                    <div class="student-register__verification-text">

                        <h1 class="student-register__verification-title">
                            Archivo de verificación escolar
                        </h1>

                        <p class="student-register__verification-description">
                            En NextStep queremos mantener nuestra comunidad de la forma
                            más real posible. Adjunta el archivo de tu historial académico
                        </p>

                    </div>

                </div>


                <!-- Selector Kardex -->
                <button
                    type="button"
                    class="student-register__kardex-card"
                    data-kardex-picker
                >

                    <div class="student-register__kardex-content">

                        <img
                            src="{{ asset('images/Fileplus.svg') }}"
                            alt=""
                            class="student-register__kardex-icon"
                        >

                        <span class="student-register__kardex-title">
                            Kardex
                        </span>

                    </div>

                </button>


                <!-- Input real -->
                <input
                    type="file"
                    name="kardex"
                    accept=".pdf,application/pdf"
                    class="student-register__file-input"
                    data-kardex-input
                >


                <!-- Nombre del archivo -->
                <p
                    class="student-register__file-name"
                    data-kardex-name
                    hidden
                ></p>


                <button
                    type="button"
                    class="
                        student-register__confirm
                        student-register__confirm--kardex
                    "
                    data-student-register
                >
                    Confirmar
                </button>

            </div>

        </div>

    </div>

</div>