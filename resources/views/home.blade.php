@extends('layouts.app')

@section('title', 'Inicio | NextStep')

@section('content')

<div class="landing-page">

    <!-- PRIMER BLOQUE / HERO  -->
    <section class="landing-hero">

        <div class="landing-hero__container">

            <!-- Header exclusivo de Landing Page -->
            <header class="landing-header reveal-on-scroll">

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="NextStep"
                    class="landing-header__logo"
                >

                <nav class="landing-header__actions">

                    <a
                        href="{{ route('login') }}"
                        class="landing-header__button landing-header__button--login"
                    >
                        Iniciar sesión
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="landing-header__button landing-header__button--register"
                    >
                        Registrarse
                    </a>

                </nav>

            </header>


            <!-- Contenido principal -->
            <div class="landing-hero__content">

                <div class="landing-hero__text reveal-on-scroll">

                    <h1 class="landing-hero__title">
                        Preparándote para dar el siguiente paso
                    </h1>

                    <p class="landing-hero__description">
                        Explora
                        <strong><em>NextStep</em></strong>
                        y todas las oportunidades que brindan para estudiantes
                        que buscan ganar experiencia antes de entrar al mundo laboral y
                        empresas que desean hacer su equipo más grande
                        <em>¡Aquí todos ganan!</em>
                    </p>

                </div>


                <img
                    src="{{ asset('images/landing-hero.png') }}"
                    alt="NextStep"
                    class="landing-hero__image reveal-on-scroll"
                >

            </div>

        </div>

    </section>


    <!-- SEGUNDO BLOQUE / SOBRE NOSOTROS  -->
    <section class="landing-about">

        <div class="landing-about__container">

            <div class="landing-about__intro reveal-on-scroll">

                <img
                    src="{{ asset('images/about-us.png') }}"
                    alt="Sobre NextStep"
                    class="landing-about__image"
                >

                <div class="landing-about__content">

                    <div class="landing-about__badge">
                        Sobre nosotros
                    </div>

                    <h2 class="landing-about__title">
                        Contribuyendo e impactando en la vida de miles de estudiantes y empresas
                    </h2>

                    <p class="landing-about__description">
                        El equipo de
                        <strong>NextStep</strong>
                        te da la bienvenida a su sitio web. Nuestro objetivo
                        es ayudar a los jóvenes estudiantes que buscan ganar experiencia antes de
                        entrar al mundo laboral. En nuestra página web encontrarás únicamente
                        vacantes para realizar prácticas profesionales en cualquier área profesional.
                    </p>

                    <p class="landing-about__description">
                        Así mismo, nuestra labor se extiende hasta el mundo empresarial.
                        ¿Buscas practicantes para laborar en tu empresa? Forma parte de nuestra
                        suscripción empresarial y consigue que miles de estudiantes se unan a tu equipo.
                    </p>

                </div>

            </div>


            <!-- Estadísticas -->
            <div class="landing-about__stats reveal-on-scroll">

                <div class="landing-about__stat-card">

                    <div class="landing-about__stat-number">
                        10k+
                    </div>

                    <p class="landing-about__stat-description">
                        Más de 10mil estudiantes se han unido a nuestra plataforma.
                        ¡Muchas gracias!
                    </p>

                </div>


                <div class="landing-about__stat-card">

                    <div class="landing-about__stat-number">
                        5k+
                    </div>

                    <p class="landing-about__stat-description">
                        Tenemos a más de 5mil empresas bajo nuestra suscripción especial.
                        ¡Todas ellas en busca de practicantes!
                    </p>

                </div>


                <div class="landing-about__stat-card">

                    <div class="landing-about__stat-number">
                        9k+
                    </div>

                    <p class="landing-about__stat-description">
                        Nuestra comunidad tiene más de 9mil reseñas positivas que comparten
                        el impacto que generó en sus vidas las oportunidades laborales dentro
                        de NextStep.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- TERCER BLOQUE / CONTACTO  -->
    <section class="landing-contact">

        <div class="landing-contact__panel">

            <div class="landing-contact__badge reveal-on-scroll">
                Contacto
            </div>


            <div class="landing-contact__content">

                <div class="landing-contact__heading reveal-on-scroll">

                    <h2 class="landing-contact__title">
                        Contáctanos
                    </h2>

                    <p class="landing-contact__description">
                        Si tienes dudas del funcionamiento de nuestra página, ideas de cómo
                        implementarla o necesitas otro tipo de ayuda, no esperes más y
                        contáctanos. Nuestro equipo responderá lo más rápido posible.
                    </p>

                </div>


                <div class="landing-contact__info reveal-on-scroll">

                    <div class="landing-contact__info-item">
                        <h3>Oficina</h3>

                        <p>
                            Pedro de Alba S/N, Niños Héroes, Ciudad Universitaria,
                            66455 San Nicolás de los Garza, N.L.
                        </p>
                    </div>


                    <div class="landing-contact__info-item">
                        <h3>Soporte</h3>

                        <p>
                            nextstep2026@gmail.com
                            <br>
                            +528183294000
                        </p>
                    </div>


                    <div class="landing-contact__info-item">
                        <h3>Horario de oficina</h3>

                        <p>
                            Lunes - Viernes
                            <br>
                            9 am - 9 pm
                        </p>
                    </div>


                    <div class="landing-contact__info-item">
                        <h3>
                            Horario de atención al
                            <br>
                            cliente
                        </h3>

                        <p>
                            Lunes - Viernes
                            <br>
                            9 am - 6 pm
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection