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
        >

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
                    type="text"
                    class="company-register__input"
                    required
                >

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
                    type="password"
                    class="company-register__input"
                    autocomplete="new-password"
                    required
                >

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
                    type="password"
                    class="company-register__input"
                    autocomplete="new-password"
                    required
                >

            </div>


            <!-- Confirmar -->
            <button
                type="submit"
                class="
                    student-register__confirm
                    company-register__confirm
                "
            >
                Confirmar
            </button>

        </form>

    </div>

</div>