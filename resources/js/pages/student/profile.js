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


    const form = card.querySelector(
        '[data-profile-form]'
    )

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

    const cancelButton = card.querySelector(
        '[data-profile-cancel]'
    )

    const password = card.querySelector(
        '[data-profile-password]'
    )

    const passwordConfirmation = card.querySelector(
        '[data-profile-password-confirmation]'
    )

    const avatarInput = card.querySelector(
        '[data-profile-avatar-input]'
    )

    const avatarContainer = card.querySelector(
        '[data-profile-avatar-container]'
    )


    const profileInputs = card.querySelectorAll(
        '[data-profile-input]'
    )

    const profileFiles = card.querySelectorAll(
        '[data-profile-file]'
    )

    const originalValues = {}

    let originalAvatarHtml = ''


    if (avatarContainer) {
        originalAvatarHtml = avatarContainer.innerHTML
    }


    const setEditing = (editing) => {

        card.classList.toggle(
            'student-profile-card--editing',
            editing
        )

        background?.classList.toggle(
            'student-profile-card__background--editing',
            editing
        )

        if (viewName) {
            viewName.hidden = editing
        }

        if (viewInfo) {
            viewInfo.hidden = editing
        }

        if (editName) {
            editName.hidden = !editing
        }

        if (editInfo) {
            editInfo.hidden = !editing
        }

        if (editButton) {
            editButton.hidden = editing
        }

        if (editActions) {
            editActions.hidden = !editing
        }

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


    const clearFiles = () => {

        profileFiles.forEach((input) => {

            input.value = ''

        })

    }


    const clearPasswords = () => {

        if (password) {
            password.value = ''
        }

        if (passwordConfirmation) {
            passwordConfirmation.value = ''
            passwordConfirmation.setCustomValidity('')
        }

    }


    const restoreAvatar = () => {

        if (!avatarContainer) {
            return
        }

        avatarContainer.innerHTML = originalAvatarHtml

    }


    const previewAvatar = (file) => {

        if (
            !file ||
            !avatarContainer
        ) {
            return
        }

        const reader = new FileReader()

        reader.addEventListener('load', () => {

            const image = avatarContainer.querySelector(
                '[data-profile-avatar-image]'
            )

            const emptyAvatar = avatarContainer.querySelector(
                '[data-profile-avatar-empty]'
            )

            if (emptyAvatar) {
                emptyAvatar.remove()
            }

            if (image) {

                image.src = reader.result

                return
            }

            const newImage = document.createElement('img')

            newImage.src = reader.result
            newImage.alt = 'Foto del perfil'
            newImage.className = 'student-profile-card__avatar'
            newImage.dataset.profileAvatarImage = ''

            avatarContainer.prepend(newImage)

        })

        reader.readAsDataURL(file)

    }


    editButton?.addEventListener(
        'click',
        () => {

            saveOriginalValues()

            if (avatarContainer) {
                originalAvatarHtml = avatarContainer.innerHTML
            }

            setEditing(true)

        }
    )


    avatarInput?.addEventListener(
        'change',
        () => {

            const file =
                avatarInput.files?.[0]

            if (!file) {
                return
            }

            previewAvatar(file)

        }
    )


    cancelButton?.addEventListener(
        'click',
        () => {

            restoreOriginalValues()
            clearFiles()
            clearPasswords()
            restoreAvatar()
            setEditing(false)

        }
    )


    password?.addEventListener(
        'input',
        () => {

            passwordConfirmation?.setCustomValidity('')

        }
    )


    passwordConfirmation?.addEventListener(
        'input',
        () => {

            passwordConfirmation.setCustomValidity('')

        }
    )


    form?.addEventListener(
        'submit',
        (event) => {

            if (
                !password ||
                !passwordConfirmation
            ) {
                return
            }


            if (
                password.value !==
                passwordConfirmation.value
            ) {

                event.preventDefault()

                passwordConfirmation.setCustomValidity(
                    'Las contraseñas no coinciden.'
                )

                passwordConfirmation.reportValidity()

            }

        }
    )


    if (
        card.dataset.initialEditing === 'true'
    ) {

        saveOriginalValues()

        if (avatarContainer) {
            originalAvatarHtml = avatarContainer.innerHTML
        }

        setEditing(true)

    }

})