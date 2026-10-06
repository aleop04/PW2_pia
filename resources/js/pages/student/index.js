import { sectorOptions } from '../../data/sectorOptions.js'


document.addEventListener('DOMContentLoaded', () => {

    const page = document.querySelector('[data-student-home]')

    if (!page) {
        return
    }


    /*  DATOS DE VACANTES  */

    const vacanciesData = page.querySelector(
        '[data-vacancies-json]'
    )

    const vacancies = vacanciesData
        ? JSON.parse(vacanciesData.textContent)
        : []


    /*  BÚSQUEDA AVANZADA  */

    const searchForm = page.querySelector(
        '[data-vacancy-search]'
    )

    const advancedToggle = page.querySelector(
        '[data-advanced-toggle]'
    )

    const advancedPanel = page.querySelector(
        '[data-advanced-panel]'
    )

    const advancedIcon = page.querySelector(
        '[data-advanced-icon]'
    )


    advancedToggle?.addEventListener('click', () => {

        const isOpen =
            advancedToggle.getAttribute('aria-expanded') === 'true'

        const newState = !isOpen

        advancedToggle.setAttribute(
            'aria-expanded',
            String(newState)
        )

        advancedPanel.hidden = !newState

        searchForm.classList.toggle(
            'vacancy-search--expanded',
            newState
        )

        advancedIcon.classList.toggle(
            'vacancy-search__advanced-icon--open',
            newState
        )

    })


    /*  DROPDOWN DE SECTOR  */

    const sectorTrigger = page.querySelector(
        '[data-sector-trigger]'
    )

    const sectorMenu = page.querySelector(
        '[data-sector-menu]'
    )

    const sectorInput = page.querySelector(
        '[data-sector-input]'
    )

    const sectorLabel = page.querySelector(
        '[data-sector-label]'
    )

    const sectorIcon = page.querySelector(
        '[data-sector-icon]'
    )


    const closeSectorDropdown = () => {

        sectorMenu.hidden = true

        sectorTrigger.classList.remove(
            'vacancy-search__sector-trigger--open'
        )

        sectorIcon.classList.remove(
            'vacancy-search__sector-icon--open'
        )

    }


    const openSectorDropdown = () => {

        sectorMenu.hidden = false

        sectorTrigger.classList.add(
            'vacancy-search__sector-trigger--open'
        )

        sectorIcon.classList.add(
            'vacancy-search__sector-icon--open'
        )

    }


    sectorOptions.forEach((option) => {

        const button = document.createElement('button')

        button.type = 'button'

        button.className =
            'vacancy-search__sector-option'

        button.textContent = option.label

        button.dataset.value = option.value


        button.addEventListener('click', () => {

            sectorInput.value = option.value
            sectorLabel.textContent = option.label

            sectorLabel.classList.remove(
                'vacancy-search__sector-placeholder'
            )


            sectorMenu
                .querySelectorAll(
                    '.vacancy-search__sector-option'
                )
                .forEach((item) => {

                    item.classList.toggle(
                        'vacancy-search__sector-option--selected',
                        item === button
                    )

                })


            closeSectorDropdown()

        })


        sectorMenu.appendChild(button)

    })


    sectorTrigger?.addEventListener('click', () => {

        if (sectorMenu.hidden) {
            openSectorDropdown()
            return
        }

        closeSectorDropdown()

    })


    document.addEventListener('click', (event) => {

        const dropdown = page.querySelector(
            '.vacancy-search__sector-dropdown'
        )

        if (!dropdown?.contains(event.target)) {
            closeSectorDropdown()
        }

    })


    /*  FORMULARIO DE BÚSQUEDA  */

    searchForm?.addEventListener('submit', (event) => {

        event.preventDefault()

        const formData = new FormData(searchForm)

        const filters = Object.fromEntries(
            formData.entries()
        )

        console.log(
            'Filtros de búsqueda:',
            filters
        )

        /*
         * Más adelante estos filtros se enviarán
         * a Laravel para consultar las vacantes
         * reales de la base de datos.
         */

    })


    /*  VISTA PREVIA  */

    const preview = page.querySelector(
        '[data-vacancy-preview]'
    )

    const bookmarkButton = page.querySelector(
        '[data-preview-bookmark]'
    )

    const bookmarkIcon = page.querySelector(
        '[data-preview-bookmark-icon]'
    )


    const savedVacancyIds = new Set()


    const getPreviewElement = (selector) => {
        return preview?.querySelector(selector)
    }


    const updateBookmark = () => {

        if (!preview || !bookmarkButton || !bookmarkIcon) {
            return
        }

        const vacancyId =
            String(preview.dataset.vacancyId)

        const saved =
            savedVacancyIds.has(vacancyId)


        bookmarkButton.classList.toggle(
            'vacancy-preview__bookmark--saved',
            saved
        )


        bookmarkButton.setAttribute(
            'aria-label',
            saved
                ? 'Quitar vacante de guardados'
                : 'Guardar vacante'
        )


        bookmarkIcon.src = saved
            ? page.dataset.bookmarkFilledIcon
            : page.dataset.bookmarkIcon

    }


    const updatePreview = (vacancy) => {

        if (!preview || !vacancy) {
            return
        }


        preview.dataset.vacancyId =
            String(vacancy.id)

        const titleLink = getPreviewElement(
            '[data-preview-title]'
        )

        titleLink.textContent = vacancy.title

        titleLink.href =
            page.dataset.vacancyDetailUrl.replace(
                '__ID__',
                vacancy.id
            )


        const companyLink = getPreviewElement(
            '[data-preview-company]'
        )

        if (companyLink) {

            companyLink.textContent =
                vacancy.company

            companyLink.href =
                page.dataset.companyProfileUrl.replace(
                    '__ID__',
                    vacancy.companyId
                )

        }


        getPreviewElement(
            '[data-preview-location]'
        ).textContent =
            vacancy.location


        getPreviewElement(
            '[data-preview-salary-modality]'
        ).textContent =
            `${vacancy.salary} - ${vacancy.modality}`


        getPreviewElement(
            '[data-preview-duration]'
        ).textContent =
            vacancy.stayDuration


        getPreviewElement(
            '[data-preview-job-type]'
        ).textContent =
            vacancy.jobType


        getPreviewElement(
            '[data-preview-description]'
        ).textContent =
            vacancy.description


        /* PRESTACIONES */

        const benefitsContainer =
            getPreviewElement(
                '[data-preview-benefits]'
            )


        benefitsContainer.replaceChildren()


        ;(vacancy.benefits || []).forEach(
            (benefit) => {

                const tag =
                    document.createElement('span')

                tag.className =
                    'vacancy-preview__benefit'

                tag.textContent =
                    benefit

                benefitsContainer.appendChild(tag)

            }
        )


        updateBookmark()

    }


    /*  SELECCIONAR VACANTE  */

    const vacancyCards = page.querySelectorAll(
        '[data-vacancy-card]'
    )


    vacancyCards.forEach((card) => {

        card.addEventListener('click', () => {

            const vacancyId =
                String(card.dataset.vacancyId)

            const vacancy =
                vacancies.find(
                    (item) =>
                        String(item.id) === vacancyId
                )


            if (!vacancy) {
                return
            }


            updatePreview(vacancy)

        })

    })


    /*  GUARDAR VACANTE  */

    bookmarkButton?.addEventListener(
        'click',
        () => {

            const vacancyId =
                String(preview.dataset.vacancyId)


            if (
                savedVacancyIds.has(vacancyId)
            ) {

                savedVacancyIds.delete(
                    vacancyId
                )

            } else {

                savedVacancyIds.add(
                    vacancyId
                )

            }


            updateBookmark()

        }
    )

})