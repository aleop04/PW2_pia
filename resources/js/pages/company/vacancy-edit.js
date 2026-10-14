const vacancyEdit =
    document.querySelector('[data-vacancy-edit]')


if (vacancyEdit) {

    const form =
        vacancyEdit.querySelector(
            '[data-vacancy-edit-form]'
        )


    /*  BENEFITS  */

    const benefitButtons =
        vacancyEdit.querySelectorAll(
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


    form?.addEventListener('submit', event => {
        form.querySelectorAll('[data-benefit-value-input]').forEach(input => input.remove())
        const selected = vacancyEdit.querySelectorAll('.company-vacancy-form__benefit--selected')
        const error = vacancyEdit.querySelector('[data-benefits-error]')
        error.hidden = selected.length > 0
        if (!selected.length) {
            event.preventDefault()
            error.scrollIntoView({ behavior: 'smooth', block: 'center' })
            return
        }
        selected.forEach(button => {
            const input = document.createElement('input')
            input.type = 'hidden'
            input.name = 'benefits[]'
            input.value = button.dataset.benefitValue
            input.dataset.benefitValueInput = ''
            form.appendChild(input)
        })
    })
}
