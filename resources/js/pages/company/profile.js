document.addEventListener('DOMContentLoaded', () => {
    const page = document.querySelector('[data-company-profile]')

    if (!page) {
        return
    }

    const form = page.querySelector('[data-company-profile-form]')

    if (!form) {
        return
    }


    /*  ELEMENTOS  */

    const editableFields = page.querySelectorAll(
        '[data-company-editable]'
    )

    const editButton = page.querySelector(
        '[data-company-edit]'
    )

    const saveButton = page.querySelector(
        '[data-company-save]'
    )

    const cancelButton = page.querySelector(
        '[data-company-cancel]'
    )


    /* SECTOR */

    const sectorView = page.querySelector(
        '[data-company-sector-view]'
    )

    const sectorSelect = page.querySelector(
        '[data-company-sector]'
    )

    const customSectorWrapper = page.querySelector(
        '[data-company-custom-sector-wrapper]'
    )

    const customSectorInput = page.querySelector(
        '[data-company-custom-sector]'
    )


    /* CONTRASEÑA */

    const passwordFields = page.querySelector(
        '[data-company-password-fields]'
    )

    const passwordInputs = page.querySelectorAll(
        '[data-company-password]'
    )


    /* DESCRIPCIÓN */

    const descriptionView = page.querySelector(
        '[data-company-description-view]'
    )

    const descriptionInput = page.querySelector(
        '[data-company-description-input]'
    )


    /* LOGO */

    const logoInput = page.querySelector(
        '[data-company-logo]'
    )

    const companyImage = page.querySelector(
        '[data-company-image]'
    )


    let logoPreviewUrl = null


    /*  DESCRIPCIÓN AUTOMÁTICA */

    const resizeDescription = () => {
        if (!descriptionInput) {
            return
        }

        descriptionInput.style.height = 'auto'

        descriptionInput.style.height =
            `${descriptionInput.scrollHeight}px`
    }


    /*  SECTOR "OTRO"  */

    const updateCustomSector = () => {
        if (
            !sectorSelect ||
            !customSectorWrapper ||
            !customSectorInput
        ) {
            return
        }

        const isEditing =
            page.classList.contains('is-editing')

        const isOther =
            sectorSelect.value === 'other'

        const shouldShow =
            isEditing && isOther

        customSectorWrapper.hidden = !shouldShow
        customSectorInput.disabled = !shouldShow
    }


    /*  MODO EDICIÓN  */

    const setEditing = (isEditing) => {
        page.classList.toggle(
            'is-editing',
            isEditing
        )


        /* Estado y ciudad */

        editableFields.forEach(field => {
            field.readOnly = !isEditing
        })


        /* Sector */

        if (sectorView) {
            sectorView.hidden = isEditing
        }

        if (sectorSelect) {
            sectorSelect.hidden = !isEditing
            sectorSelect.disabled = !isEditing
        }

        updateCustomSector()


        /* Contraseña */

        if (passwordFields) {
            passwordFields.hidden = !isEditing
        }

        passwordInputs.forEach(input => {
            input.disabled = !isEditing
        })


        /* Descripción */

        if (descriptionView) {
            descriptionView.hidden = isEditing
        }

        if (descriptionInput) {
            descriptionInput.hidden = !isEditing
            descriptionInput.disabled = !isEditing
        }


        /* Logo */

        if (logoInput) {
            logoInput.disabled = !isEditing
        }


        /* Botones */

        if (editButton) {
            editButton.hidden = isEditing
        }

        if (saveButton) {
            saveButton.hidden = !isEditing
        }

        if (cancelButton) {
            cancelButton.hidden = !isEditing
        }


        if (isEditing) {
            requestAnimationFrame(() => {
                resizeDescription()
            })
        }
    }


    /*  EDITAR  */

    editButton?.addEventListener('click', () => {
        setEditing(true)

        sectorSelect?.focus()
    })


    /*  CANCELAR  */

    cancelButton?.addEventListener('click', () => {

        window.location.reload()
    })


    /*  CAMBIO DE SECTOR  */

    sectorSelect?.addEventListener(
        'change',
        updateCustomSector
    )


    /*  DESCRIPCIÓN  */

    descriptionInput?.addEventListener(
        'input',
        resizeDescription
    )


    /*  PREVIEW DEL LOGO  */

    logoInput?.addEventListener('change', () => {
        const file = logoInput.files?.[0]

        if (!file || !companyImage) {
            return
        }

        if (!file.type.startsWith('image/')) {
            return
        }

        if (logoPreviewUrl) {
            URL.revokeObjectURL(logoPreviewUrl)
        }

        logoPreviewUrl =
            URL.createObjectURL(file)

        companyImage.src =
            logoPreviewUrl
    })


    /*  ESTADO INICIAL  */

    const initialEdit =
        page.dataset.companyInitialEdit === 'true'

    setEditing(initialEdit)


    /*  LIMPIEZA  */

    window.addEventListener('beforeunload', () => {
        if (logoPreviewUrl) {
            URL.revokeObjectURL(logoPreviewUrl)
        }
    })
})