<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>@yield('title', 'NextStep')</title>

    <link
        rel="icon"
        href="{{ asset('images/favicon.png') }}"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body>

    <div class="auth-layout">
        @yield('content')
    </div>

</body>

</html>