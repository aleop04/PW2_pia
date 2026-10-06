<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>NextStep</title>

    <link
        rel="icon"
        href="{{ asset('images/favicon.png') }}"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
        }


        /* LAYOUT */

        .company-layout {
            min-height: 100vh;

            display: flex;
            flex-direction: column;
        }

        .company-layout__content {
            flex: 1;
        }


        /* HEADER */

        .app-header {
            width: 100%;
            height: 116px;

            padding: 38px 85px;

            background: #ffffff;

            box-shadow:
                0 2px 4px rgba(0, 0, 0, 0.25);

            box-sizing: border-box;

            position: relative;
            z-index: 100;
        }

        .app-header__content {
            width: 100%;
            height: 40px;

            display: flex;
            align-items: center;
            justify-content: space-between;
        }


        /* Logo */

        .app-header__logo-link {
            display: flex;
            align-items: center;

            text-decoration: none;
        }

        .app-header__logo {
            width: 140px;
            height: 30px;

            object-fit: contain;

            display: block;
        }


        /* Botones */

        .app-header__actions {
            display: flex;
            align-items: center;

            gap: 24px;
        }

        .app-header__button {
            width: 40px;
            height: 40px;

            padding: 0;

            border: 0;

            background: transparent;

            display: flex;
            align-items: center;
            justify-content: center;

            cursor: pointer;

            text-decoration: none;
        }

        .app-header__icon {
            width: 40px;
            height: 40px;

            display: block;
        }

    </style>

</head>


<body>

    <div class="company-layout">

        <x-app-header
            home-route="company.home"
            action-icon="Dollarsign.svg"
            action-route="company.membership"
            action-label="Ver membresía"
            profile-route="company.profile"
        />


        <main class="company-layout__content">

            @yield('content')

        </main>

        @include('components.footer')

    </div>

</body>

</html>