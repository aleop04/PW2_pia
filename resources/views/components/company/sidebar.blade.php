<aside class="company-sidebar">

    <nav class="company-sidebar__menu">


        {{-- DASHBOARD --}}

        <a
            href="{{ route('company.home') }}"
            class="
                company-sidebar__item
                {{ request()->routeIs('company.home')
                    ? 'company-sidebar__item--active'
                    : '' }}
            "
        >

            <img
                src="{{ asset('images/Grid.svg') }}"
                alt=""
                class="company-sidebar__icon"
            >

            <span>
                Dashboard
            </span>

        </a>


        {{-- VACANTES --}}

        <a
            href="{{ route('company.vacancies.index') }}"
            class="
                company-sidebar__item
                {{ request()->routeIs('company.vacancies.*')
                    ? 'company-sidebar__item--active'
                    : '' }}
            "
        >

            <img
                src="{{ asset('images/Filedash.svg') }}"
                alt=""
                class="company-sidebar__icon"
            >

            <span>
                Vacantes
            </span>

        </a>


        {{-- SOLICITUDES --}}

        <a
            href="{{ route('company.applications') }}"
            class="
                company-sidebar__item
                {{ request()->routeIs('company.applications*')
                    ? 'company-sidebar__item--active'
                    : '' }}
            "
        >

            <img
                src="{{ asset('images/Smile.svg') }}"
                alt=""
                class="company-sidebar__icon"
            >

            <span>
                Solicitudes
            </span>

        </a>


        {{-- VALORACIONES --}}

        <a
            href="{{ route('company.ratings') }}"
            class="
                company-sidebar__item
                {{ request()->routeIs('company.ratings')
                    ? 'company-sidebar__item--active'
                    : '' }}
            "
        >

            <img
                src="{{ asset('images/Stardash.svg') }}"
                alt=""
                class="company-sidebar__icon"
            >

            <span>
                Valoraciones
            </span>

        </a>

    </nav>

</aside>