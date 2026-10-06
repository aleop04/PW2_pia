<footer class="footer">

    <!-- Fondo rojo -->
    <div class="footer__background"></div>

    <!-- Contenido -->
    <div class="footer__content">

        <!-- IZQUIERDA -->
        <div class="footer__office">

            <div class="footer__text-block">
                <h3>Oficina</h3>

                <p>
                    Pedro de Alba S/N, Niños Héroes, Ciudad Universitaria,
                    66455 San Nicolás de los Garza, N.L.
                </p>
            </div>

            <!-- Logos / instituciones -->
            <div class="footer__institutions">

                <img
                    src="{{ asset('images/logo1.png') }}"
                    alt="Institución 1"
                    class="footer__institution-logo footer__institution-logo--small"
                >

                <img
                    src="{{ asset('images/logo2.png') }}"
                    alt="Institución 2"
                    class="footer__institution-logo footer__institution-logo--large"
                >

                <img
                    src="{{ asset('images/logo3.png') }}"
                    alt="Institución 3"
                    class="footer__institution-logo footer__institution-logo--medium"
                >

            </div>

        </div>


        <!-- CENTRO -->
        <div class="footer__brand">

            <img
                src="{{ asset('images/favicon.png') }}"
                alt="NextStep"
                class="footer__main-logo"
            >

            <img
                src="{{ asset('images/footer-name.png') }}"
                alt="NextStep"
                class="footer__brand-name"
            >

        </div>


        <!-- DERECHA -->
        <div class="footer__support">

            <div class="footer__text-block">
                <h3>Soporte</h3>

                <p>
                    nextstep2026@gmail.com
                    <br>
                    +52 81 8329 4000
                </p>
            </div>

            <div class="footer__policies">
                <a href="#">Cookies policy</a>
                <a href="#">Privacy policy</a>
                <span>© {{ date('Y') }}</span>
            </div>

        </div>

    </div>

</footer>