const companyProfile = document.querySelector('[data-company-profile]')

if (companyProfile) {

    const editButton = companyProfile.querySelector('[data-edit-button]')

    const profileFields = companyProfile.querySelectorAll(
        '[data-profile-field]'
    )

    const passwordFields = companyProfile.querySelector(
        '[data-password-fields]'
    )

    const passwordInput = companyProfile.querySelector(
        '[data-password]'
    )

    const passwordConfirmationInput = companyProfile.querySelector(
        '[data-password-confirmation]'
    )

    const descriptionText = companyProfile.querySelector(
        '[data-description-text]'
    )

    const descriptionInput = companyProfile.querySelector(
        '[data-description-input]'
    )


    let isEditing = false


    const resizeDescription = () => {

        if (!descriptionInput) {
            return
        }

        descriptionInput.style.height = 'auto'

        descriptionInput.style.height =
            `${descriptionInput.scrollHeight}px`

    }


    const enableEditMode = () => {

        isEditing = true

        profileFields.forEach((field) => {
            field.disabled = false
        })


        passwordFields.hidden = false


        descriptionText.hidden = true
        descriptionInput.hidden = false


        editButton.textContent = 'Guardar datos'


        requestAnimationFrame(() => {
            resizeDescription()
        })

    }


    const disableEditMode = () => {

        isEditing = false

        profileFields.forEach((field) => {
            field.disabled = true
        })


        passwordFields.hidden = true


        passwordInput.value = ''
        passwordConfirmationInput.value = ''


        descriptionText.textContent = descriptionInput.value

        descriptionInput.hidden = true
        descriptionText.hidden = false


        editButton.textContent = 'Editar datos'

    }


    editButton.addEventListener('click', () => {

        if (isEditing) {
            disableEditMode()

            return
        }

        enableEditMode()

    })


    descriptionInput.addEventListener(
        'input',
        resizeDescription
    )

}