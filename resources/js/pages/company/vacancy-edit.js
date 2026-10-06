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


    /*  SUBMIT  */

    form?.addEventListener('submit', (event) => {

        event.preventDefault()


        /*   HTML VALIDATION  */

        if (!form.checkValidity()) {

            form.reportValidity()

            return
        }


        /*  BENEFITS VALIDATION  */

        const selectedBenefits =
            vacancyEdit.querySelectorAll(
                '.company-vacancy-form__benefit--selected'
            )


        if (selectedBenefits.length === 0) {

            alert(
                'Debes seleccionar al menos una prestación.'
            )


            const benefitsSection =
                vacancyEdit.querySelector(
                    '.company-vacancy-form__benefits'
                )


            benefitsSection?.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            })


            return
        }


        /*   GET VALUES  */

        const title =
            form.elements.title.value.trim()


        const modality =
            form.elements.modality.value


        const location =
            form.elements.location.value.trim()


        const duration =
            form.elements.stay_duration.value


        const salary =
            form.elements.salary_fixed.value


        const periodicity =
            form.elements.periodicity.value


        const description =
            form.elements.description.value.trim()


        const benefits =
            Array.from(selectedBenefits).map(
                (button) =>
                    button.dataset.benefitValue
            )


        /*  TEMPORARY UPDATE  */

        const updatedVacancy = {

            id:
                vacancyEdit.dataset.vacancyId,

            title,

            modality,

            location,

            stayDuration: duration,

            salaryFixed:
                Number(salary),

            periodicity,

            description,

            benefits

        }


        console.log(
            'Actualizar vacante:',
            updatedVacancy
        )


        /*
         * Después aquí irá la actualización
         * real en Laravel:
         *
         * PATCH / PUT
         */


        /*  RETURN TO DETAIL  */

        const detailUrl =
            vacancyEdit.dataset.vacancyDetailUrl


        if (detailUrl) {

            window.location.href =
                detailUrl

        }

    })

}