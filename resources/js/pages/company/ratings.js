const companyRatings =
    document.querySelector('[data-company-ratings]')


if (companyRatings) {

    const sort =
        companyRatings.querySelector(
            '[data-ratings-sort]'
        )


    const trigger =
        sort?.querySelector(
            '[data-sort-trigger]'
        )


    const label =
        sort?.querySelector(
            '[data-sort-label]'
        )


    const icon =
        sort?.querySelector(
            '[data-sort-icon]'
        )


    const menu =
        sort?.querySelector(
            '[data-sort-menu]'
        )


    const options =
        sort?.querySelectorAll(
            '[data-sort-option]'
        )


    const reviewList =
        companyRatings.querySelector(
            '[data-review-list]'
        )


    /*  CERRAR DROPDOWN  */

    const closeSort = () => {

        menu.hidden = true

        icon?.classList.remove(
            'company-ratings__sort-icon--open'
        )

        trigger?.setAttribute(
            'aria-expanded',
            'false'
        )

    }


    /*   ABRIR / CERRAR  */

    trigger?.addEventListener('click', () => {

        const isOpen = !menu.hidden


        if (isOpen) {

            closeSort()

            return
        }


        menu.hidden = false

        icon?.classList.add(
            'company-ratings__sort-icon--open'
        )

        trigger.setAttribute(
            'aria-expanded',
            'true'
        )

    })


    /*  ORDENAR  */

    options?.forEach((option) => {

        option.addEventListener('click', () => {

            const sortValue =
                option.dataset.sortValue


            label.textContent =
                option.textContent.trim()


            options.forEach((item) => {

                item.classList.remove(
                    'company-ratings__sort-option--active'
                )

            })


            option.classList.add(
                'company-ratings__sort-option--active'
            )


            const reviews =
                Array.from(
                    reviewList.querySelectorAll(
                        '[data-review]'
                    )
                )


            reviews.sort((a, b) => {

                const dateA =
                    new Date(a.dataset.reviewDate)

                const dateB =
                    new Date(b.dataset.reviewDate)


                return sortValue === 'recent'
                    ? dateB - dateA
                    : dateA - dateB

            })


            reviews.forEach((review) => {
                reviewList.appendChild(review)
            })


            closeSort()

        })

    })


    /*  CERRAR AL HACER CLIC FUERA  */

    document.addEventListener('click', (event) => {

        if (
            sort
            && !sort.contains(event.target)
        ) {
            closeSort()
        }

    })

}