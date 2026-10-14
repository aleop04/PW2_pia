import { sectorOptions } from '../data/sectorOptions.js';

function initRegisterPage() {
    const page = document.querySelector('[data-register-page]');
    if (!page) return;

    // JavaScript cambia las pantallas; Laravel recibe los formularios por POST.
    const screens = [...page.querySelectorAll('[data-register-screen]')];
    let animationRunning = false;

    function showScreen(name, animate = true, backward = false) {
        const next = screens.find((screen) => screen.dataset.registerScreen === name);
        const current = screens.find((screen) => !screen.hidden);
        if (!next || animationRunning) return;

        if (!animate || !current || current === next) {
            screens.forEach((screen) => { screen.hidden = screen !== next; });
            return;
        }

        animationRunning = true;
        const exitClass = backward ? 'slide-exit-right' : 'slide-exit-left';
        const enterClass = backward ? 'slide-enter-left' : 'slide-enter-right';
        current.classList.add(exitClass);

        window.setTimeout(() => {
            current.hidden = true;
            current.classList.remove(exitClass);
            next.classList.add(enterClass);
            next.hidden = false;
            void next.offsetWidth;
            next.classList.remove(enterClass);
            window.setTimeout(() => { animationRunning = false; }, 400);
        }, 400);
    }

    page.querySelectorAll('[data-account-type]').forEach((button) => {
        button.addEventListener('click', () => showScreen(button.dataset.accountType));
    });
    page.querySelectorAll('[data-password-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.dataset.passwordToggle);
            if (!input) return;
            const visible = input.type === 'password';
            input.type = visible ? 'text' : 'password';
            button.textContent = visible ? 'Ocultar contraseña' : 'Ver contraseña';
        });
    });
    page.querySelectorAll('[data-student-back-account], [data-company-back]').forEach((button) => {
        button.addEventListener('click', () => showScreen('account-type', true, true));
    });

    const dropdown = page.querySelector('[data-sector-dropdown]');
    const trigger = page.querySelector('[data-sector-trigger]');
    const menu = page.querySelector('[data-sector-menu]');
    const input = page.querySelector('[data-sector-input]');
    const label = page.querySelector('[data-sector-label]');
    const icon = page.querySelector('[data-sector-icon]');
    const custom = page.querySelector('[data-custom-sector]');
    const error = page.querySelector('[data-sector-error]');

    function setMenu(open) {
        if (!menu || !trigger) return;
        menu.hidden = !open;
        trigger.setAttribute('aria-expanded', String(open));
        icon?.classList.toggle('company-register__select-icon--open', open);
    }

    function selectSector(option) {
        input.value = option.value;
        label.textContent = option.label;
        label.classList.remove('company-register__sector-placeholder');
        menu.querySelectorAll('[data-sector-value]').forEach((button) => {
            button.classList.toggle('company-register__sector-option--selected',
                button.dataset.sectorValue === option.value);
        });
        if (custom) {
            custom.hidden = option.value !== 'other';
            custom.required = option.value === 'other';
            if (option.value !== 'other') custom.value = '';
        }
        trigger.setAttribute('aria-invalid', 'false');
        if (error) error.hidden = true;
        setMenu(false);
    }

    if (dropdown && trigger && menu && input && label) {
        menu.replaceChildren();
        sectorOptions.forEach((option) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'company-register__sector-option';
            button.dataset.sectorValue = option.value;
            button.textContent = option.label;
            button.addEventListener('click', () => selectSector(option));
            menu.appendChild(button);
        });

        // Al volver por un error del servidor recupera el sector y el campo Otro.
        const previous = sectorOptions.find((option) => option.value === input.value);
        if (previous) selectSector(previous);
        trigger.addEventListener('click', () => setMenu(menu.hidden));
        document.addEventListener('click', (event) => {
            if (event.target instanceof Node && !dropdown.contains(event.target)) setMenu(false);
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') setMenu(false);
        });

        page.querySelector('[data-company-form]')?.addEventListener('submit', (event) => {
            if (!input.value) {
                event.preventDefault();
                if (error) error.hidden = false;
                trigger.setAttribute('aria-invalid', 'true');
                setMenu(true);
                trigger.focus();
            }
        });
    }

    showScreen(page.dataset.initialScreen || 'account-type', false);
    setMenu(false);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initRegisterPage);
} else {
    initRegisterPage();
}
