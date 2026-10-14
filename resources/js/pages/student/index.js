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

        const query = String(filters.query || '').toLocaleLowerCase('es-MX').trim()
        const location = String(filters.location || '').toLocaleLowerCase('es-MX').trim()
        const minSalary = Number(filters.min_salary || 0)
        const maxSalary = Number(filters.max_salary || 0)
        const age = Number(filters.publication_age || 0)
        const sector = String(filters.sector || '')
        vacancyCards.forEach(card => {
            const vacancy = vacancies.find(item => String(item.id) === String(card.dataset.vacancyId))
            card.hidden = !vacancy || !(
                (!query || `${vacancy.title} ${vacancy.company}`.toLocaleLowerCase('es-MX').includes(query)) &&
                (!location || vacancy.location.toLocaleLowerCase('es-MX').includes(location)) &&
                (!minSalary || vacancy.salaryFixed >= minSalary) &&
                (!maxSalary || vacancy.salaryFixed <= maxSalary) &&
                (!sector || vacancy.sector === sector) &&
                (!age || (vacancy.createdAt && Date.now() - Date.parse(vacancy.createdAt) <= age * 86400000))
            )
        })

    })


    /*  VISTA PREVIA  */

    const preview = page.querySelector(
        '[data-vacancy-preview]'
    )

    const getPreviewElement = (selector) => {
        return preview?.querySelector(selector)
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

        const apply = getPreviewElement('[data-preview-apply]')
        const applied = getPreviewElement('[data-preview-applied]')
        if (apply) {
            apply.hidden = Boolean(vacancy.applied)
        }
        if (applied) applied.hidden = !vacancy.applied

        const applicationForm = page.querySelector('[data-application-form]')
        if (applicationForm) {
            applicationForm.action = page.dataset.applicationUrl.replace('__ID__', vacancy.id)
            applicationForm.querySelector('[name="vacancy_id"]').value = String(vacancy.id)
        }

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

    if (page.dataset.initialVacancyId) {
        const initial = vacancies.find(item => String(item.id) === page.dataset.initialVacancyId)
        if (initial) updatePreview(initial)
    }

})
