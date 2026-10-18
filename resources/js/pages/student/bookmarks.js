document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-bookmark-form]').forEach(form => {
        form.addEventListener('submit', async event => {
            event.preventDefault()
            const button = form.querySelector('[data-bookmark-button]')
            const method = form.querySelector('[data-bookmark-method]')
            const saved = form.dataset.saved === 'true'
            const page = form.closest('[data-student-home], [data-student-vacancy-detail]')
            button.disabled = true
            try {
                const result = await fetch(form.action, {
                    method: saved ? 'DELETE' : 'POST',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value }
                })
                if (!result.ok) throw new Error('No se pudo actualizar la vacante guardada.')
                const { saved: current } = await result.json()
                form.dataset.saved = String(current)
                method.disabled = !current
                const label = current ? 'Quitar de guardadas' : 'Guardar vacante'
                button.setAttribute('aria-label', label)
                button.setAttribute('aria-pressed', String(current))
                button.title = label
                form.querySelector('[data-bookmark-image]').src = current ? page.dataset.bookmarkFilledIcon : page.dataset.bookmarkIcon
                const item = page.querySelector('[data-vacancies-json]')
                if (item) {
                    const vacancies = JSON.parse(item.textContent)
                    const vacancy = vacancies.find(v => String(v.id) === form.dataset.vacancyId)
                    if (vacancy) vacancy.saved = current
                    item.textContent = JSON.stringify(vacancies)
                    page.dispatchEvent(new CustomEvent('bookmark-changed', { detail: { id: form.dataset.vacancyId, saved: current } }))
                }
            } catch (error) {
                const message = page.querySelector('[data-bookmark-feedback]')
                if (message) { message.textContent = error.message; message.hidden = false }
            } finally { button.disabled = false }
        })
    })
})
