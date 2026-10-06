@extends('layouts.company')

@section('content')

<main class="company-home">

    <div class="company-home__navigation">

        @include('components.company.publish-button')

        @include('components.company.sidebar')

    </div>


    <div class="company-home__workspace">

        <section class="company-home__content">

            @yield('dashboard-content')

        </section>

    </div>

</main>

@endsection