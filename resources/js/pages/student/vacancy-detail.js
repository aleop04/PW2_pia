document.addEventListener('DOMContentLoaded', () => {

    const page = document.querySelector(
        '[data-student-vacancy-detail]'
    )

    if (!page) {
        return
    }


    /*  GUARDAR VACANTE  */

    const bookmarkButton = page.querySelector(
        '[data-detail-bookmark]'
    )

    const bookmarkIcon = page.querySelector(
        '[data-detail-bookmark-icon]'
    )

    let isSaved = false


    bookmarkButton?.addEventListener('click', () => {

        isSaved = !isSaved

        bookmarkIcon.src = isSaved
            ? page.dataset.bookmarkFilledIcon
            : page.dataset.bookmarkIcon


        bookmarkButton.setAttribute(
            'aria-label',
            isSaved
                ? 'Quitar vacante de guardados'
                : 'Guardar vacante'
        )


        /*
         * Más adelante:
         * guardar/quitar mediante Laravel.
         */

    })


    /*  POSTULACIÓN  */

    const modal = page.querySelector(
        '[data-review-modal]'
    )

    const openButton = page.querySelector(
        '[data-application-open]'
    )

    const applicationForm = page.querySelector(
        '[data-application-form]'
    )

    const cvInput = page.querySelector(
        '[data-cv-input]'
    )

    const cvName = page.querySelector(
        '[data-cv-name]'
    )

    const cvMessage = page.querySelector(
        '[data-cv-message]'
    )


    /*  ABRIR / CERRAR MODAL  */

    const openModal = () => {

        if (!modal) {
            return
        }

        modal.hidden = false

        document.body.style.overflow = 'hidden'

    }


    const closeModal = () => {

        if (!modal) {
            return
        }

        modal.hidden = true

        document.body.style.overflow = ''

    }


    openButton?.addEventListener(
        'click',
        openModal
    )


    /*
    * Cerrar al hacer clic únicamente
    * sobre el fondo del modal.
    */

    modal?.addEventListener('click', (event) => {

        if (event.target === modal) {
            closeModal()
        }

    })


    /*
    * Cerrar con Escape.
    */

    document.addEventListener('keydown', (event) => {

        if (
            event.key === 'Escape' &&
            modal &&
            !modal.hidden
        ) {
            closeModal()
        }

    })


    /*  CAMBIAR CV  */

    cvInput?.addEventListener('change', () => {

        const file = cvInput.files[0]


        if (!file) {
            return
        }


        /*
        * Comprobamos que sea PDF.
        */

        const fileIsPdf =
            file.type === 'application/pdf' ||
            file.name
                .toLowerCase()
                .endsWith('.pdf')


        if (!fileIsPdf) {

            cvInput.value = ''

            cvMessage.textContent =
                'Selecciona un archivo PDF.'

            cvMessage.hidden = false

            return
        }


        cvMessage.hidden = true
        cvMessage.textContent = ''

        cvName.textContent = file.name

    })


    /*  ENVIAR POSTULACIÓN  */

    applicationForm?.addEventListener(
        'submit',
        (event) => {

            event.preventDefault()

            const applicationData =
                new FormData(applicationForm)

            console.log(
                'Datos de la postulación:',
                {
                    fullName:
                        applicationData.get('full_name'),

                    email:
                        applicationData.get('email'),

                    phone:
                        applicationData.get('phone'),

                    location:
                        applicationData.get('location'),

                    cv:
                        applicationData.get('cv'),
                }
            )


            /*
            * Más adelante aquí enviaremos
            * applicationData a Laravel.
            */


            closeModal()


            /*
            * Ocultamos "Postularse" porque
            * simulamos que ya se postuló.
            */

            openButton.hidden = true

        }
    )

})