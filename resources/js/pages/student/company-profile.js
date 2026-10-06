document.addEventListener('DOMContentLoaded', () => {

    const page = document.querySelector(
        '[data-company-public-profile]'
    )

    if (!page) {
        return
    }


    /*  PESTAÑAS  */

    const tabs = page.querySelectorAll(
        '[data-profile-tab]'
    )

    const sections = page.querySelectorAll(
        '[data-profile-section]'
    )


    tabs.forEach((tab) => {

        tab.addEventListener('click', () => {

            const target = tab.dataset.profileTab

            tabs.forEach((item) => {

                item.classList.toggle(
                    'company-public-profile__tab--active',
                    item === tab
                )

            })


            sections.forEach((section) => {

                section.hidden =
                    section.dataset.profileSection !== target

            })

        })

    })


    /*  VALORACIONES  */

    const reviewsJson = page.querySelector(
        '[data-reviews-json]'
    )

    const reviews = reviewsJson
        ? JSON.parse(reviewsJson.textContent)
        : []

    const reviewList = page.querySelector(
        '[data-review-list]'
    )


    const formatDate = (date) => {

        if (!date) {
            return ''
        }

        const [year, month, day] = date.split('-')

        return `${day}/${month}/${year}`

    }


    const renderStars = (rating) => {

        return Array.from(
            { length: 5 },
            (_, index) => {

                const filled =
                    index + 1 <= rating

                const image = filled
                    ? '/images/Star.svg'
                    : '/images/Starnofill.svg'

                return `
                    <img
                        src="${image}"
                        alt=""
                        class="company-public-profile__review-star"
                    >
                `

            }
        ).join('')

    }


    const renderReviews = (items) => {

        if (!reviewList) {
            return
        }

        reviewList.innerHTML = items
            .map((review) => {

                const duration = review.duration
                    ? `<span>${review.duration}</span>`
                    : ''

                return `
                    <article class="company-public-profile__review">

                        <div class="company-public-profile__review-rating">

                            <div class="company-public-profile__review-stars">
                                ${renderStars(review.rating)}
                            </div>

                            <span class="company-public-profile__review-date">
                                ${formatDate(review.date)}
                            </span>

                        </div>


                        <div class="company-public-profile__review-info">

                            <div class="company-public-profile__review-meta">

                                <span>
                                    ${review.position}
                                </span>

                                ${duration}

                            </div>

                        </div>


                        <p class="company-public-profile__review-comment">
                            ${review.comment}
                        </p>

                    </article>
                `

            })
            .join('')

    }


    renderReviews(reviews)


    /*  ORDENAR VALORACIONES  */

    const sortTrigger = page.querySelector(
        '[data-sort-trigger]'
    )

    const sortMenu = page.querySelector(
        '[data-sort-menu]'
    )

    const sortLabel = page.querySelector(
        '[data-sort-label]'
    )

    const sortIcon = page.querySelector(
        '[data-sort-icon]'
    )

    const sortOptions = page.querySelectorAll(
        '[data-sort-value]'
    )


    const closeSort = () => {

        sortMenu.hidden = true

        sortTrigger.setAttribute(
            'aria-expanded',
            'false'
        )

        sortIcon.classList.remove(
            'company-public-profile__sort-icon--open'
        )

    }


    sortTrigger?.addEventListener('click', () => {

        const opening = sortMenu.hidden

        sortMenu.hidden = !opening

        sortTrigger.setAttribute(
            'aria-expanded',
            String(opening)
        )

        sortIcon.classList.toggle(
            'company-public-profile__sort-icon--open',
            opening
        )

    })


    sortOptions.forEach((option) => {

        option.addEventListener('click', () => {

            const value =
                option.dataset.sortValue

            const sorted =
                [...reviews]


            switch (value) {

                case 'oldest':

                    sorted.sort(
                        (a, b) =>
                            new Date(a.date) -
                            new Date(b.date)
                    )

                    break


                case 'best':

                    sorted.sort(
                        (a, b) =>
                            b.rating - a.rating
                    )

                    break


                case 'worst':

                    sorted.sort(
                        (a, b) =>
                            a.rating - b.rating
                    )

                    break


                case 'recent':

                default:

                    sorted.sort(
                        (a, b) =>
                            new Date(b.date) -
                            new Date(a.date)
                    )

            }


            sortLabel.textContent =
                option.textContent.trim()


            sortOptions.forEach((item) => {

                item.classList.toggle(
                    'company-public-profile__sort-option--active',
                    item === option
                )

            })


            renderReviews(sorted)

            closeSort()

        })

    })


    document.addEventListener('click', (event) => {

        const sort = page.querySelector(
            '.company-public-profile__sort'
        )

        if (!sort?.contains(event.target)) {
            closeSort()
        }

    })


    /*  MODAL  */

    const modal = page.querySelector(
        '[data-rating-modal]'
    )

    const openModalButton = page.querySelector(
        '[data-rating-open]'
    )

    const closeModalButton = page.querySelector(
        '[data-rating-close]'
    )


    const openModal = () => {

        modal.hidden = false

        document.body.style.overflow =
            'hidden'

    }


    const closeModal = () => {

        modal.hidden = true

        document.body.style.overflow =
            ''

    }


    openModalButton?.addEventListener(
        'click',
        openModal
    )


    closeModalButton?.addEventListener(
        'click',
        closeModal
    )


    modal?.addEventListener('click', (event) => {

        if (event.target === modal) {
            closeModal()
        }

    })


    document.addEventListener('keydown', (event) => {

        if (
            event.key === 'Escape' &&
            modal &&
            !modal.hidden
        ) {
            closeModal()
        }

    })


    /*  ESTRELLAS DEL MODAL  */

    const ratingInput = page.querySelector(
        '[data-rating-value]'
    )

    const ratingStars = page.querySelectorAll(
        '[data-rating-star]'
    )


    ratingStars.forEach((button) => {

        button.addEventListener('click', () => {

            const selectedRating =
                Number(button.dataset.ratingStar)

            ratingInput.value =
                selectedRating


            ratingStars.forEach((starButton) => {

                const starValue =
                    Number(
                        starButton.dataset.ratingStar
                    )

                const image =
                    starButton.querySelector('img')

                image.src =
                    starValue <= selectedRating
                        ? '/images/Star.svg'
                        : '/images/Starnofill.svg'

            })

        })

    })


    /*  FECHAS DEL MODAL  */

    const dateInputs = page.querySelectorAll(
        '[data-rating-date]'
    )


    dateInputs.forEach((input) => {

        input.addEventListener('change', () => {

            const text = page.querySelector(
                `[data-rating-date-text="${input.name}"]`
            )

            if (!text) {
                return
            }


            text.textContent =
                formatDate(input.value) ||
                'DD/MM/AAAA'


            text.classList.toggle(
                'rating-modal__date-text--empty',
                !input.value
            )


            if (input.name === 'start_date') {

                const endDate =
                    page.querySelector(
                        '[data-rating-end-date]'
                    )

                if (endDate) {
                    endDate.min = input.value
                }

            }

        })

    })


    /*  ENVIAR VALORACIÓN  */

    const ratingForm = page.querySelector(
        '[data-rating-form]'
    )


    ratingForm?.addEventListener(
        'submit',
        (event) => {

            event.preventDefault()


            if (
                Number(ratingInput.value) === 0
            ) {
                return
            }


            const formData =
                new FormData(ratingForm)

            const ratingData =
                Object.fromEntries(
                    formData.entries()
                )


            console.log(
                'Valoración enviada:',
                ratingData
            )


            /*
             * Más adelante:
             * enviar ratingData a Laravel.
             */


            closeModal()

        }
    )

})