@extends('layouts.company')

@section('content')

<main
    class="change-membership-page"
    data-change-membership-page
    data-membership-url="{{ route('company.membership') }}"
>

    @include('auth.register.company-membership')

</main>

@endsection