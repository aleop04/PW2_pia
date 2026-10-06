const companyApplications =
    document.querySelector('[data-company-applications]')


if (companyApplications) {

    const vacancyFilter =
        companyApplications.querySelector(
            '[data-vacancy-filter]'
        )


    const trigger =
        vacancyFilter?.querySelector(
            '[data-vacancy-trigger]'
        )


    const triggerText =
        vacancyFilter?.querySelector(
            '[data-vacancy-trigger-text]'
        )


    const menu =
        vacancyFilter?.querySelector(
            '[data-vacancy-menu]'
        )


    const options =
        vacancyFilter?.querySelectorAll(
            '[data-vacancy-option]'
        )


    const applicationCards =
        companyApplications.querySelectorAll(
            '[data-application-card]'
        )


    const emptyMessage =
        companyApplications.querySelector(
            '[data-applications-empty]'
        )


    /* ========================================
       ABRIR / CERRAR
    ======================================== */

    const closeDropdown = () => {

        menu.hidden = true

        trigger.classList.remove(
            'company-applications__filter-trigger--open'
        )

        trigger.setAttribute(
            'aria-expanded',
            'false'
        )

    }


    trigger?.addEventListener('click', () => {

        const isOpen = !menu.hidden

        if (isOpen) {

            closeDropdown()

            return
        }


        menu.hidden = false

        trigger.classList.add(
            'company-applications__filter-trigger--open'
        )

        trigger.setAttribute(
            'aria-expanded',
            'true'
        )

    })


    /* ========================================
       FILTRAR
    ======================================== */

    options?.forEach((option) => {

        option.addEventListener('click', () => {

            const selectedVacancy =
                option.dataset.vacancyId


            triggerText.textContent =
                option.textContent.trim()


            options.forEach((item) => {

                item.classList.remove(
                    'company-applications__filter-option--active'
                )

            })


            option.classList.add(
                'company-applications__filter-option--active'
            )


            let visibleApplications = 0


            applicationCards.forEach((card) => {

                const matchesVacancy =
                    selectedVacancy === 'all'
                    || card.dataset.vacancyId === selectedVacancy


                card.hidden = !matchesVacancy


                if (matchesVacancy) {
                    visibleApplications++
                }

            })


            if (emptyMessage) {

                emptyMessage.hidden =
                    visibleApplications !== 0

            }


            closeDropdown()

        })

    })


    /* ========================================
       CERRAR AL HACER CLIC FUERA
    ======================================== */

    document.addEventListener('click', (event) => {

        if (
            vacancyFilter
            && !vacancyFilter.contains(event.target)
        ) {

            closeDropdown()

        }

    })

}