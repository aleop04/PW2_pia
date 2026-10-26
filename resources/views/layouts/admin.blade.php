<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administración') | NextStep</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="admin-layout">
    <header class="admin-header">
        <a href="{{ route('admin.home') }}"><img src="{{ asset('images/logo.png') }}" alt="NextStep" width="140" height="30"></a>
        <div class="admin-header__actions"><span>{{ auth('web')->user()->first_name }} · Administración</span>
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="admin-button" type="submit">Cerrar sesión</button></form>
        </div>
    </header>
    <div class="admin-shell">
        <aside class="admin-navigation"><nav class="admin-sidebar" aria-label="Administración">
            @foreach (['students' => ['Estudiantes', 'Users.svg'], 'companies' => ['Empresas', 'Briefcase.svg'], 'memberships' => ['Membresías', 'File.svg'], 'payments' => ['Pagos', 'Dollarsign.svg']] as $section => [$label, $icon])
                <a href="{{ route('admin.'.$section.'.index') }}" @if(request()->routeIs('admin.'.$section.'.*')) aria-current="page" @endif><img src="{{ asset('images/'.$icon) }}" alt="" width="24" height="24">{{ $label }}</a>
            @endforeach
        </nav></aside>
        <main class="admin-main">
            @if (session('success'))<p class="admin-feedback" role="status">{{ session('success') }}</p>@endif
            @if ($errors->any())<div class="admin-errors" role="alert"><p>Revisa los siguientes datos:</p><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @yield('content')
        </main>
    </div>
    @include('components.footer')
</div>
</body>
</html>
