document.addEventListener('DOMContentLoaded', () => {

    const page = document.querySelector(
        '[data-student-profile-page]'
    )

    if (!page) {
        return
    }


    const card = page.querySelector(
        '[data-student-profile-card]'
    )

    if (!card) {
        return
    }


    const background = card.querySelector(
        '[data-profile-background]'
    )

    const viewName = card.querySelector(
        '[data-profile-view-name]'
    )

    const editName = card.querySelector(
        '[data-profile-edit-name]'
    )

    const viewInfo = card.querySelector(
        '[data-profile-view-info]'
    )

    const editInfo = card.querySelector(
        '[data-profile-edit-info]'
    )

    const editButton = card.querySelector(
        '[data-profile-edit]'
    )

    const editActions = card.querySelector(
        '[data-profile-edit-actions]'
    )

    const confirmButton = card.querySelector(
        '[data-profile-confirm]'
    )

    const cancelButton = card.querySelector(
        '[data-profile-cancel]'
    )


    const originalValues = {}


    const profileInputs = card.querySelectorAll(
        '[data-profile-input]'
    )


    const setEditing = (editing) => {

        card.classList.toggle(
            'student-profile-card--editing',
            editing
        )

        background.classList.toggle(
            'student-profile-card__background--editing',
            editing
        )

        viewName.hidden = editing
        viewInfo.hidden = editing

        editName.hidden = !editing
        editInfo.hidden = !editing

        editButton.hidden = editing
        editActions.hidden = !editing

    }


    const saveOriginalValues = () => {

        profileInputs.forEach((input) => {

            originalValues[
                input.dataset.profileInput
            ] = input.value

        })

    }


    const restoreOriginalValues = () => {

        profileInputs.forEach((input) => {

            const key =
                input.dataset.profileInput

            input.value =
                originalValues[key] ?? ''

        })

    }


    editButton?.addEventListener(
        'click',
        () => {

            saveOriginalValues()

            setEditing(true)

        }
    )


    cancelButton?.addEventListener(
        'click',
        () => {

            restoreOriginalValues()

            setEditing(false)

        }
    )


    confirmButton?.addEventListener(
        'click',
        () => {

            const password =
                card.querySelector(
                    '[data-profile-password]'
                )

            const passwordConfirmation =
                card.querySelector(
                    '[data-profile-password-confirmation]'
                )


            if (
                password.value !==
                passwordConfirmation.value
            ) {

                alert(
                    'Las contraseñas no coinciden.'
                )

                return
            }


            const profileData = {}

            profileInputs.forEach((input) => {

                profileData[
                    input.dataset.profileInput
                ] = input.value

            })


            profileData.password =
                password.value

            profileData.passwordConfirmation =
                passwordConfirmation.value


            console.log(
                'Datos actualizados del estudiante:',
                profileData
            )


            /*
             * Más adelante estos datos se enviarán
             * al backend para actualizar el perfil.
             */


            setEditing(false)

        }
    )


    /*  DOCUMENTOS  */

    const kardexButton = card.querySelector(
        '[data-profile-kardex]'
    )

    const cvButton = card.querySelector(
        '[data-profile-cv]'
    )


    kardexButton?.addEventListener(
        'click',
        () => {

            console.log(
                'Abrir Kardex del estudiante'
            )

        }
    )


    cvButton?.addEventListener(
        'click',
        () => {

            console.log(
                'Abrir CV del estudiante'
            )

        }
    )

})