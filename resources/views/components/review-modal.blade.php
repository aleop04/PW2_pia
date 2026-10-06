@props([
    'title',
])

<div
    class="review-modal__overlay"
    data-review-modal
    hidden
>

    <div class="review-modal">

        <div class="review-modal__body">

            <div class="review-modal__header">

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