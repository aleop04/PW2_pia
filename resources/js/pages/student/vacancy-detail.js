document.addEventListener('DOMContentLoaded', () => {
    const page = document.querySelector('[data-student-home], [data-student-vacancy-detail]')
    const modal = page?.querySelector('[data-review-modal]')
    if (!modal) return

    let trigger = null
    const close = modal.querySelector('[data-review-close]')
    const body = modal.querySelector('.review-modal__body')
    const cvInput = modal.querySelector('[data-cv-input]')
    const cvName = modal.querySelector('[data-cv-name]')
    const cvMessage = modal.querySelector('[data-cv-message]')

    function openModal(button) {
        trigger = button
        modal.hidden = false
        document.body.style.overflow = 'hidden'
        body.scrollTop = 0
        close.focus()
    }

    function closeModal() {
        modal.hidden = true
        document.body.style.overflow = ''
        trigger?.focus()
    }

    page.querySelector('[data-application-open]')?.addEventListener('click', event => openModal(event.currentTarget))
    close.addEventListener('click', closeModal)
    modal.addEventListener('click', event => { if (event.target === modal) closeModal() })
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && !modal.hidden) closeModal()
    })

    // Tras un error de validación, Laravel conserva los datos y vuelve a mostrar la confirmación.
    if (page.dataset.openOnError === 'true' && page.querySelector('[data-application-open]:not([hidden])')) {
        openModal(page.querySelector('[data-application-open]'))
    }

    cvInput?.addEventListener('change', () => {
        const file = cvInput.files[0]
        if (!file) return
        if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
            cvInput.value = ''
            cvMessage.textContent = 'Selecciona un archivo PDF.'
            cvMessage.hidden = false
            return
        }
        cvMessage.hidden = true
        cvMessage.textContent = ''
        cvName.textContent = file.name
    })
})
