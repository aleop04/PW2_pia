document.addEventListener('DOMContentLoaded', () => {
    const page = document.querySelector('[data-company-profile]')
    const form = page?.querySelector('[data-company-profile-form]')
    if (!form) return

    const fields = page.querySelectorAll('[data-company-editable]')
    const logo = page.querySelector('[data-company-logo]')
    const edit = page.querySelector('[data-company-edit]')
    const save = page.querySelector('[data-company-save]')
    edit.addEventListener('click', () => {
        fields.forEach(field => { field.readOnly = false })
        logo.disabled = false
        save.disabled = false
        edit.setAttribute('aria-pressed', 'true')
        fields[fields.length - 1]?.focus()
    })
    // Los errores de validación dejan los campos editables para corregirlos.
    if (!save.disabled) edit.setAttribute('aria-pressed', 'true')
})
