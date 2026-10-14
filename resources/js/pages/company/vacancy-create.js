const vacancyCreate =
    document.querySelector('[data-vacancy-create]')


if (vacancyCreate) {

    const form =
        vacancyCreate.querySelector(
            '[data-vacancy-form]'
        )


    /*  BENEFITS  */

    const benefitButtons =
        vacancyCreate.querySelectorAll(
            '[data-benefit]'
        )


    benefitButtons.forEach((button) => {

        button.addEventListener('click', () => {

            button.classList.toggle(
                'company-vacancy-form__benefit--selected'
            )


            const icon =
                button.querySelector(
                    '[data-benefit-icon]'
                )


            icon?.classList.toggle(
                'company-vacancy-form__benefit-icon--selected'
            )

        })

    })


    /*  MODAL  */

    const modal =
        vacancyCreate.querySelector(
            '[data-review-modal]'
        )


    const cancelButton =
        vacancyCreate.querySelector(
            '[data-review-cancel]'
        )


    const confirmButton =
        vacancyCreate.querySelector(
            '[data-review-confirm]'
        )


    const closeModal = () => {

        if (!modal) {
            return
        }


        modal.hidden = true

        document.body.style.overflow = ''

    }


    /*  FORM SUBMIT → REVIEW  */

    form?.addEventListener('submit', (event) => {

        event.preventDefault()


        /*  VALIDACIÓN HTML  */

        if (!form.checkValidity()) {

            form.reportValidity()

            return
        }


        /*  OBTENER DATOS  */

        const title =
            form.elements.title.value.trim()


        const modality =
            form.elements.modality.value


        const location =
            form.elements.location.value.trim()


        const duration =
            form.elements.stay_duration.value


        const description =
            form.elements.description.value.trim()


        const salary =
            form.elements.salary_fixed.value.trim()


        const periodicity =
            form.elements.periodicity.value


        /*  VALIDAR CAMPOS DE TEXTO  */

        if (title === '') {

            form.elements.title.focus()

            return
        }


        if (location === '') {

            form.elements.location.focus()

            return
        }


        if (description === '') {

            form.elements.description.focus()

            return
        }


        /*  VALIDAR SUELDO  */

        if (
            salary === ''
            || Number(salary) <= 0
        ) {

            form.elements.salary_fixed.focus()

            form.elements.salary_fixed.reportValidity()

            return
        }


        /*  VALIDAR PRESTACIONES  */

        const selectedBenefits =
            vacancyCreate.querySelectorAll(
                '.company-vacancy-form__benefit--selected'
            )


        const benefitsError = vacancyCreate.querySelector('[data-benefits-error]')
        benefitsError.hidden = selectedBenefits.length > 0
        if (selectedBenefits.length === 0) {
            benefitsError.scrollIntoView({ behavior: 'smooth', block: 'center' })
            return
        }

        /*  PREPARAR SALARIO  */

        const salaryText =
            `$${Number(salary).toLocaleString('es-MX')} - ${periodicity}`


        /*  REVISIÓN - TÍTULO  */

        vacancyCreate.querySelector(
            '[data-review-title]'
        ).textContent = title


        /*  REVISIÓN - MODALIDAD  */

        vacancyCreate.querySelector(
            '[data-review-modality]'
        ).textContent = modality


        /*  REVISIÓN - UBICACIÓN  */

        vacancyCreate.querySelector(
            '[data-review-location]'
        ).textContent = location


        /*  REVISIÓN - DURACIÓN  */

        vacancyCreate.querySelector(
            '[data-review-duration]'
        ).textContent = duration


        /*  REVISIÓN - SALARIO  */

        vacancyCreate.querySelector(
            '[data-review-salary]'
        ).textContent = salaryText


        /*  REVISIÓN - DESCRIPCIÓN  */

        vacancyCreate.querySelector(
            '[data-review-description]'
        ).textContent = description


        /*  REVISIÓN - PRESTACIONES  */

        const reviewBenefits =
            vacancyCreate.querySelector(
                '[data-review-benefits]'
            )


        reviewBenefits.innerHTML = ''


        selectedBenefits.forEach((button) => {

            const benefit =
                document.createElement('span')


            benefit.className =
                'vacancy-review__benefit'


            const text =
                document.createElement('span')


            text.textContent =
                button.dataset.benefitValue


            const icon =
                document.createElement('img')


            icon.src =
                '/images/Pluscircle.svg'

            icon.alt = ''


            benefit.appendChild(text)
            benefit.appendChild(icon)

            reviewBenefits.appendChild(benefit)

        })


        /*  ABRIR MODAL  */

        if (modal) {

            modal.hidden = false

            document.body.style.overflow = 'hidden'

        }

    })


    /*  CANCELAR MODAL  */

    cancelButton?.addEventListener(
        'click',
        closeModal
    )


    /*  CONFIRMAR PUBLICACIÓN  */

    confirmButton?.addEventListener(
        'click',
        () => {

            form.querySelectorAll('[data-benefit-value-input]').forEach(input => input.remove())
            vacancyCreate.querySelectorAll('.company-vacancy-form__benefit--selected').forEach(button => {
                const input = document.createElement('input')
                input.type = 'hidden'
                input.name = 'benefits[]'
                input.value = button.dataset.benefitValue
                input.dataset.benefitValueInput = ''
                form.appendChild(input)
            })
            form.submit()

        }
    )


    /*  CLICK EN OVERLAY  */

    modal
        ?.querySelector(
            '.vacancy-review-modal__overlay'
        )
        ?.addEventListener(
            'click',
            closeModal
        )

}