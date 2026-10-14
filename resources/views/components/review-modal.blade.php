@props([
    'title',
])

<div
    class="review-modal__overlay"
    data-review-modal
    role="dialog"
    aria-modal="true"
    aria-label="{{ $title }}"
    hidden
>

    <div class="review-modal">

        <div class="review-modal__body">

            <div class="review-modal__header">

                <button type="button" class="review-modal__close" data-review-close aria-label="Cerrar confirmación">×</button>

                <h2 class="review-modal__title">
                    {{ $title }}
                </h2>

                <div class="review-modal__description">
                    {{ $description ?? '' }}
                </div>

            </div>


            <div class="review-modal__content">
                {{ $slot }}
            </div>

        </div>


        <footer class="review-modal__footer">
            {{ $actions ?? '' }}
        </footer>

    </div>

</div>
