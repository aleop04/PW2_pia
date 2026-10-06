const applicantProfile =
    document.querySelector('[data-applicant-profile]')


if (applicantProfile) {

    const applicationsUrl =
        applicantProfile.dataset.applicationsUrl


    const downloadCvButton =
        applicantProfile.querySelector(
            '[data-download-cv]'
        )


    const acceptButton =
        applicantProfile.querySelector(
            '[data-accept-application]'
        )


    const rejectButton =
        applicantProfile.querySelector(
            '[data-reject-application]'
        )


    /* ========================================
       CV
    ======================================== */

    downloadCvButton?.addEventListener(
        'click',
        () => {

            console.log(
                'Descargar CV:',
                downloadCvButton.dataset.cv
            )

            /*
             * Después aquí irá la descarga
             * real del archivo.
             */

        }
    )


    /* ========================================
       ACCEPT
    ======================================== */

    acceptButton?.addEventListener(
        'click',
        () => {

            console.log(
                'Solicitud aceptada'
            )

            /*
             * Después aquí actualizaremos
             * realmente el estado en la BD.
             */

            if (applicationsUrl) {
                window.location.href = applicationsUrl
            }

        }
    )


    /* ========================================
       REJECT
    ======================================== */

    rejectButton?.addEventListener(
        'click',
        () => {

            console.log(
                'Solicitud rechazada'
            )

            /*
             * Después aquí actualizaremos
             * realmente el estado en la BD.
             */

            if (applicationsUrl) {
                window.location.href = applicationsUrl
            }

        }
    )

}