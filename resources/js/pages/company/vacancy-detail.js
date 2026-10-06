const companyVacancyDetail =
    document.querySelector(
        '[data-company-vacancy-detail]'
    )


if (companyVacancyDetail) {

    const deleteButton =
        companyVacancyDetail.querySelector(
            '[data-delete-vacancy]'
        )


    const modal =
        document.querySelector(
            '[data-delete-vacancy-modal]'
        )


    const cancelButton =
        modal?.querySelector(
            '[data-delete-cancel]'
        )


    const confirmButton =
        modal?.querySelector(
            '[data-delete-confirm]'
        )


    /*  OPEN MODAL  */

    const openDeleteModal = () => {

        if (!modal) {
            return
        }


        modal.hidden = false

        document.body.style.overflow = 'hidden'

    }


    /* CLOSE MODAL  */

    const closeDeleteModal = () => {

        if (!modal) {
            return
        }


        modal.hidden = true

        document.body.style.overflow = ''

    }


    /*   DELETE BUTTON  */

    deleteButton?.addEventListener(
        'click',
        openDeleteModal
    )


    /*  CANCEL  */

    cancelButton?.addEventListener(
        'click',
        closeDeleteModal
    )


    /*  CONFIRM DELETE  */

    confirmButton?.addEventListener(
        'click',
        () => {

            const vacancyId =
                companyVacancyDetail.dataset.vacancyId


            console.log(
                'Vacante eliminada:',
                vacancyId
            )


            /*
             * Después aquí irá la eliminación
             * real en la base de datos.
             *
             * DELETE /vacancies/:id
             */


            const vacanciesUrl =
                companyVacancyDetail.dataset.vacanciesUrl


            closeDeleteModal()


            if (vacanciesUrl) {

                window.location.href =
                    vacanciesUrl

            }

        }
    )


    /*  CLICK FUERA DEL MODAL  */

    modal?.addEventListener(
        'click',
        (event) => {

            if (event.target === modal) {

                closeDeleteModal()

            }

        }
    )


    /*  ESCAPE  */

    document.addEventListener(
        'keydown',
        (event) => {

            if (
                event.key === 'Escape'
                && modal
                && !modal.hidden
            ) {

                closeDeleteModal()

            }

        }
    )

}