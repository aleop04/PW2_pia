<div class="company-membership">

    <!-- =====================================
         MEMBRESÍAS
    ====================================== -->

    <section class="company-membership__plans">

        <div class="company-membership__header">

            <button
                type="button"
                class="student-register__back"
                aria-label="Regresar"
                data-membership-back
            >
                <img
                    src="{{ asset('images/Arrowleft-circle.svg') }}"
                    alt=""
                    class="student-register__back-icon"
                >
            </button>


            <h1 class="company-membership__title">
                Escoge la suscripción deseada
            </h1>

        </div>


        <div class="company-membership__options">

            <!-- BASIC -->
            <button
                type="button"
                class="
                    company-membership__card
                    company-membership__card--basic
                "
                data-membership="basic"
            >

                <span class="company-membership__card-title">
                    Basic - $100 / mes
                </span>

                <span class="company-membership__card-description">
                    Déjate envolver con nuestro plan inicial.
                    Podrás publicar 8 vacantes diferentes y
                    tendrás el 30% de alcance promocional
                </span>

            </button>


            <!-- PLUS -->
            <button
                type="button"
                class="
                    company-membership__card
                    company-membership__card--plus
                "
                data-membership="plus"
            >

                <span class="company-membership__card-title">
                    Plus - $350 / mes
                </span>

                <span class="company-membership__card-description">
                    El plan Plus te ofrece la capacidad de poder
                    publicar 16 vacantes diferentes y tendrás
                    el 60% de alcance promocional
                </span>

            </button>


            <!-- PREMIUM -->
            <button
                type="button"
                class="
                    company-membership__card
                    company-membership__card--premium
                "
                data-membership="premium"
            >

                <span class="company-membership__card-title">
                    Premium - $980 / mes
                </span>

                <span class="company-membership__card-description">
                    ¡Arrasa en tus postulaciones! Tendrás la posibilidad
                    de publicar vacantes ilimitadas y tus postulaciones
                    tendrán el mayor alcance posible
                </span>

            </button>

        </div>

    </section>


    <!-- =====================================
         DATOS DE PAGO
    ====================================== -->

    <section class="company-membership__payment">

        <h2 class="company-membership__payment-title">
            Escribe los datos correspondientes
        </h2>


        <form
            class="company-membership__payment-form"
            data-membership-payment-form
        >

            <!-- Email -->
            <div class="company-membership__field">

                <label
                    for="payment-email"
                    class="company-membership__label"
                >
                    Email
                </label>

                <input
                    id="payment-email"
                    name="payment_email"
                    type="email"
                    class="company-membership__input"
                    autocomplete="email"
                    required
                >

            </div>


            <!-- Datos tarjeta -->
            <div class="company-membership__field">

                <label
                    for="card-number"
                    class="company-membership__label"
                >
                    Detalles de la tarjeta
                </label>


                <div class="company-membership__card-details">

                    <input
                        id="card-number"
                        name="card_number"
                        type="text"
                        inputmode="numeric"
                        class="
                            company-membership__input
                            company-membership__input--card-number
                        "
                        placeholder="1234 1234 1234 1235"
                        required
                    >


                    <div class="company-membership__card-row">

                        <input
                            id="expiration-date"
                            name="expiration_date"
                            type="text"
                            inputmode="numeric"
                            class="
                                company-membership__input
                                company-membership__input--expiration
                            "
                            placeholder="MM/YY"
                            aria-label="Fecha de expiración"
                            required
                        >


                        <input
                            id="card-cvc"
                            name="cvc"
                            type="text"
                            inputmode="numeric"
                            class="
                                company-membership__input
                                company-membership__input--cvc
                            "
                            placeholder="CVC"
                            aria-label="CVC"
                            required
                        >

                    </div>

                </div>

            </div>


            <!-- Titular -->
            <div class="company-membership__field">

                <label
                    for="cardholder-name"
                    class="company-membership__label"
                >
                    Nombre del titular de la tarjeta
                </label>

                <input
                    id="cardholder-name"
                    name="cardholder_name"
                    type="text"
                    class="company-membership__input"
                    autocomplete="cc-name"
                    required
                >

            </div>


            <!-- País -->
            <div class="company-membership__field">

                <label
                    for="payment-country"
                    class="company-membership__label"
                >
                    País
                </label>

                <input
                    id="payment-country"
                    name="country"
                    type="text"
                    class="company-membership__input"
                    autocomplete="country-name"
                    required
                >

            </div>


            <!-- Código postal -->
            <div class="company-membership__field">

                <label
                    for="postal-code"
                    class="company-membership__label"
                >
                    Código postal
                </label>

                <input
                    id="postal-code"
                    name="postal_code"
                    type="text"
                    class="company-membership__input"
                    autocomplete="postal-code"
                    required
                >

            </div>


            <button
                type="submit"
                class="company-membership__payment-button"
            >
                Confirmar pago
            </button>

        </form>

    </section>

</div>