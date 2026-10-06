@props([
    'vacancy',
    'variant' => 'default',
    'href' => null,
])

@php
    $tags = array_filter([
        $vacancy['salary'] ?? null,
        $vacancy['modality'] ?? null,
        ...($vacancy['benefits'] ?? []),
    ]);

    $classes =
        'vacancy-card' .
        ($variant !== 'default'
            ? ' vacancy-card--' . $variant
            : '');
@endphp


@if ($href)

    <a
        href="{{ $href }}"
        class="{{ $classes }}"
    >

        <div class="vacancy-card__content">

            <div class="vacancy-card__header">

                <h3 class="vacancy-card__title">
                    {{ $vacancy['title'] }}
                </h3>

                <div class="vacancy-card__company-info">

                    <p class="vacancy-card__company">
                        {{ $vacancy['company'] }}
                    </p>

                    <p class="vacancy-card__location">
                        {{ $vacancy['location'] }}
                    </p>

                </div>

            </div>


            <div class="vacancy-card__tags">

                @foreach ($tags as $tag)

                    <span class="vacancy-card__tag">
                        {{ $tag }}
                    </span>

                @endforeach

            </div>

        </div>

    </a>

@else

    <button
        type="button"
        class="{{ $classes }}"
        data-vacancy-card
        data-vacancy-id="{{ $vacancy['id'] }}"
    >

        <div class="vacancy-card__content">

            <div class="vacancy-card__header">

                <h3 class="vacancy-card__title">
                    {{ $vacancy['title'] }}
                </h3>

                <div class="vacancy-card__company-info">

                    <p class="vacancy-card__company">
                        {{ $vacancy['company'] }}
                    </p>

                    <p class="vacancy-card__location">
                        {{ $vacancy['location'] }}
                    </p>

                </div>

            </div>


            <div class="vacancy-card__tags">

                @foreach ($tags as $tag)

                    <span class="vacancy-card__tag">
                        {{ $tag }}
                    </span>

                @endforeach

            </div>

        </div>

    </button>

@endif