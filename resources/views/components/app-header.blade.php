@props([
    'homeRoute',
    'profileRoute',

    'actionIcon' => null,
    'actionRoute' => null,
    'actionLabel' => null,
])

<header class="app-header">

    <div class="app-header__content">

        {{-- Logo --}}

        <a
            href="{{ route($homeRoute) }}"
            class="app-header__logo-link"
        >
            <img
                src="{{ asset('images/logo.png') }}"
                alt="NextStep"
                class="app-header__logo"
            >
        </a>


        {{-- Acciones --}}

        <nav class="app-header__actions">

            @auth('web')
                <span class="app-header__identity">
                    {{ auth('web')->user()->role === 'company'
                        ? auth('web')->user()->company_name
                        : auth('web')->user()->first_name }}
                    · {{ auth('web')->user()->role === 'company' ? 'Empresa' : 'Estudiante' }}
                </span>
            @endauth

            {{-- Acción opcional --}}

            @if ($actionIcon && $actionRoute)

                <a
                    href="{{ route($actionRoute) }}"
                    class="app-header__button"
                    aria-label="{{ $actionLabel }}"
                >
                    <img
                        src="{{ asset('images/' . $actionIcon) }}"
                        alt=""
                        class="app-header__icon"
                    >
                </a>

            @endif


            {{-- Perfil --}}

            <a
                href="{{ route($profileRoute) }}"
                class="app-header__button"
                aria-label="Ver perfil"
            >
                <img
                    src="{{ asset('images/User.svg') }}"
                    alt=""
                    class="app-header__icon"
                >
            </a>


            {{-- Cerrar sesión: POST con CSRF; ahora invalida la sesión real. --}}
            <form method="POST" action="{{ route('logout') }}" class="app-header__logout">
                @csrf
                <button type="submit" class="app-header__button" aria-label="Cerrar sesión" title="Cerrar sesión">
                    <img src="{{ asset('images/Logout.svg') }}" alt="" class="app-header__icon">
                </button>
            </form>

        </nav>

    </div>

</header>
