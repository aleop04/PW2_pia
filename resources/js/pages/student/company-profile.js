// La ficha pública muestra datos de la empresa y vacantes desde MongoDB.
const companyPage = document.querySelector('[data-company-public-profile]')
companyPage?.querySelectorAll('[data-profile-tab]').forEach(tab => {
    tab.addEventListener('click', () => {
        companyPage.querySelectorAll('[data-profile-tab]').forEach(item => {
            item.classList.toggle('company-public-profile__tab--active', item === tab)
        })
        companyPage.querySelectorAll('[data-profile-section]').forEach(section => {
            section.hidden = section.dataset.profileSection !== tab.dataset.profileTab
        })
    })
})
