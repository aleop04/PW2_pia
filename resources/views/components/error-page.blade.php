@props(['code', 'heading', 'message', 'actionLabel', 'actionRoute'])

<main class="nextstep-error" aria-labelledby="error-heading">
    <div class="nextstep-error__shell">
        <a class="nextstep-error__brand" href="{{ route('home') }}" aria-label="NextStep, ir al inicio">
            <img src="{{ asset('images/logo.png') }}" alt="NextStep">
        </a>

        <section class="nextstep-error__card">
            <span class="nextstep-error__code" aria-label="Error {{ $code }}">{{ $code }}</span>
            <h1 id="error-heading">{{ $heading }}</h1>
            <p>{{ $message }}</p>
            <a class="nextstep-error__action" href="{{ route($actionRoute) }}">{{ $actionLabel }}</a>
        </section>
    </div>
</main>
