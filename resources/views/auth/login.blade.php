@extends('layouts.auth')

@section('title', 'Iniciar sesión | NextStep')

@section('content')

<main class="login-page">

    <div class="login-page__container">

        <!-- Logo -->
        <a
            href="{{ route('home') }}"
            class="login-page__logo-link"
        >
            <img
                src="{{ asset('images/logo.png') }}"
                alt="NextStep"
                class="login-page__logo"
            >
        </a>


        <div class="login-page__content">

            <!-- Imagen lateral -->
            <div class="login-page__image-wrapper">

                <img
                    src="{{ asset('images/login-image.png') }}"
                    alt="Imagen de inicio de sesión"
                    class="login-page__image"
                >

            </div>


            <!-- Formulario -->
            <section class="login-page__form-section">

                <div class="login-page__form-content">

                    <!-- Encabezado -->
                    <div class="login-page__header">

                        <h1 class="login-page__title">
                            ¡Bienvenido/a de vuelta!
                        </h1>

                        <p class="login-page__subtitle">
                            Ingresa tus datos en los espacios
                        </p>

                    </div>


                    <!-- Formulario -->
                    <form class="login-form">

                        <!-- Email -->
                        <div class="login-form__field">

                            <label
                                for="email"
                                class="login-form__label"
                            >
                                Email
                            </label>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                class="login-form__input"
                                placeholder="correoejemplo@gmail.com"
                                autocomplete="email"
                                required
                            >

                        </div>


                        <!-- Contraseña -->
                        <div class="login-form__field">

                            <label
                                for="password"
                                class="login-form__label"
                            >
                                Contraseña
                            </label>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="login-form__input"
                                placeholder="contraseñaejemplo"
                                autocomplete="current-password"
                                required
                            >

                        </div>


                        <!-- Botón -->
                        <button
                            type="button"
                            class="login-form__button"
                        >
                            Acceder
                        </button>

                    </form>

                </div>

            </section>

        </div>

    </div>

</main>

@endsection