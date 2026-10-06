import { sectorOptions } from '../data/sectorOptions.js';


function initRegisterPage() {

    const registerPage = document.querySelector('[data-register-page]');

    if (!registerPage) {
        return;
    }


    /* =====================================================
       PANTALLAS PRINCIPALES

       account-type
       student
       company
    ===================================================== */

    const registerScreens =
        registerPage.querySelectorAll('[data-register-screen]');

    let registerAnimationRunning = false;


    const showRegisterScreen = (
        screenName,
        direction = 'forward',
        animate = true
    ) => {

        const currentScreen =
            Array.from(registerScreens).find(
                (screen) => !screen.hidden
            );

        const nextScreen =
            Array.from(registerScreens).find(
                (screen) =>
                    screen.dataset.registerScreen === screenName
            );


        if (!nextScreen) {
            return;
        }


        /*
        * Estado inicial de la página.
        * Aquí no queremos animación.
        */
        if (
            !animate ||
            !currentScreen ||
            currentScreen === nextScreen
        ) {

            registerScreens.forEach((screen) => {

                screen.hidden =
                    screen !== nextScreen;

            });

            return;
        }


        /*
        * Evita clicks repetidos mientras
        * se está ejecutando el slide.
        */
        if (registerAnimationRunning) {
            return;
        }

        registerAnimationRunning = true;


        const exitClass =
            direction === 'forward'
                ? 'slide-exit-left'
                : 'slide-exit-right';

        const enterClass =
            direction === 'forward'
                ? 'slide-enter-right'
                : 'slide-enter-left';


        /* Sale la pantalla actual */
        currentScreen.classList.add(exitClass);


        window.setTimeout(() => {

            /*
            * Ocultamos la anterior después
            * de terminar su salida.
            */
            currentScreen.hidden = true;

            currentScreen.classList.remove(exitClass);


            /*
            * Preparamos la nueva pantalla.
            */
            nextScreen.classList.add(enterClass);

            nextScreen.hidden = false;


            /*
            * Fuerza al navegador a registrar
            * la posición inicial.
            */
            void nextScreen.offsetWidth;


            /*
            * Al quitar la clase vuelve a
            * translateX(0) y opacity: 1.
            */
            nextScreen.classList.remove(enterClass);


            window.setTimeout(() => {

                registerAnimationRunning = false;

            }, 400);

        }, 400);

    };


    /* =====================================================
       TIPO DE CUENTA
    ===================================================== */

    const accountTypeButtons =
        registerPage.querySelectorAll('[data-account-type]');


    accountTypeButtons.forEach((button) => {

        button.addEventListener('click', () => {

            const accountType =
                button.dataset.accountType;


            if (
                accountType !== 'student' &&
                accountType !== 'company'
            ) {
                return;
            }


            showRegisterScreen(accountType);

        });

    });


    /* =====================================================
       ESTUDIANTE → SELECTOR DE CUENTA
    ===================================================== */

    const studentBackAccount =
        registerPage.querySelector(
            '[data-student-back-account]'
        );


    studentBackAccount?.addEventListener('click', () => {

        showRegisterScreen('account-type');

    });


    /* =====================================================
       EMPRESA → SELECTOR DE CUENTA
    ===================================================== */

    const companyBack =
        registerPage.querySelector(
            '[data-company-back]'
        );


    companyBack?.addEventListener('click', () => {

        showRegisterScreen('account-type');

    });


    /* =====================================================
       PASOS DEL REGISTRO ESTUDIANTE
    ===================================================== */

    const studentSteps =
        registerPage.querySelectorAll(
            '[data-student-step]'
        );


    const showStudentStep = (stepName) => {

        studentSteps.forEach((step) => {

            step.hidden =
                step.dataset.studentStep !== stepName;

        });

    };


    /* =====================================================
       FORMULARIO ESTUDIANTE
    ===================================================== */

    const studentForm =
        registerPage.querySelector(
            '[data-student-form]'
        );


    studentForm?.addEventListener('submit', (event) => {

        event.preventDefault();


        if (!studentForm.checkValidity()) {

            studentForm.reportValidity();

            return;
        }


        const password =
            studentForm.querySelector(
                '[name="password"]'
            );

        const passwordConfirmation =
            studentForm.querySelector(
                '[name="password_confirmation"]'
            );


        if (
            password &&
            passwordConfirmation &&
            password.value !== passwordConfirmation.value
        ) {

            passwordConfirmation.setCustomValidity(
                'Las contraseñas no coinciden.'
            );

            passwordConfirmation.reportValidity();

            return;
        }


        passwordConfirmation?.setCustomValidity('');


        showStudentStep('kardex');

    });


    /* =====================================================
       QUITAR ERROR DE CONTRASEÑA AL ESCRIBIR
    ===================================================== */

    const studentPasswordConfirmation =
        studentForm?.querySelector(
            '[name="password_confirmation"]'
        );


    studentPasswordConfirmation?.addEventListener(
        'input',
        () => {

            studentPasswordConfirmation.setCustomValidity('');

        }
    );


    /* =====================================================
       KARDEX → DATOS ESTUDIANTE
    ===================================================== */

    const studentBackData =
        registerPage.querySelector(
            '[data-student-back-data]'
        );


    studentBackData?.addEventListener('click', () => {

        showStudentStep('data');

    });


    /* =====================================================
       KARDEX
    ===================================================== */

    const kardexPicker =
        registerPage.querySelector(
            '[data-kardex-picker]'
        );

    const kardexInput =
        registerPage.querySelector(
            '[data-kardex-input]'
        );

    const kardexName =
        registerPage.querySelector(
            '[data-kardex-name]'
        );


    kardexPicker?.addEventListener('click', () => {

        kardexInput?.click();

    });


    kardexInput?.addEventListener('change', () => {

        const file =
            kardexInput.files?.[0];


        if (!file) {

            if (kardexName) {

                kardexName.textContent = '';
                kardexName.hidden = true;

            }

            return;
        }


        const isPdf =
            file.type === 'application/pdf' ||
            file.name.toLowerCase().endsWith('.pdf');


        if (!isPdf) {

            kardexInput.value = '';


            if (kardexName) {

                kardexName.textContent =
                    'Selecciona únicamente un archivo PDF.';

                kardexName.hidden = false;

            }

            return;
        }


        if (kardexName) {

            kardexName.textContent = file.name;

            kardexName.hidden = false;

        }

    });


    /* =====================================================
       CONFIRMAR REGISTRO ESTUDIANTE

       TODAVÍA NO ENVÍA AL BACKEND.
    ===================================================== */

    const studentRegisterButton =
        registerPage.querySelector(
            '[data-student-register]'
        );


    studentRegisterButton?.addEventListener(
        'click',
        () => {

            const kardexFile =
                kardexInput?.files?.[0];


            if (!kardexFile) {

                kardexInput?.click();

                return;
            }


            const studentUrl =
                registerPage.dataset.studentUrl;


            if (!studentUrl) {
                return;
            }


            window.location.href = studentUrl;

        }
    );


    /* =====================================================
       SELECTOR DE SECTOR EMPRESARIAL
    ===================================================== */

    const sectorDropdown =
        registerPage.querySelector(
            '[data-sector-dropdown]'
        );

    const sectorTrigger =
        registerPage.querySelector(
            '[data-sector-trigger]'
        );

    const sectorMenu =
        registerPage.querySelector(
            '[data-sector-menu]'
        );

    const sectorInput =
        registerPage.querySelector(
            '[data-sector-input]'
        );

    const sectorLabel =
        registerPage.querySelector(
            '[data-sector-label]'
        );

    const sectorIcon =
        registerPage.querySelector(
            '[data-sector-icon]'
        );

    const customSector =
        registerPage.querySelector(
            '[data-custom-sector]'
        );


    const openSectorDropdown = () => {

        if (
            !sectorMenu ||
            !sectorTrigger
        ) {
            return;
        }


        sectorMenu.hidden = false;


        sectorTrigger.setAttribute(
            'aria-expanded',
            'true'
        );


        sectorIcon?.classList.add(
            'company-register__select-icon--open'
        );

    };


    const closeSectorDropdown = () => {

        if (
            !sectorMenu ||
            !sectorTrigger
        ) {
            return;
        }


        sectorMenu.hidden = true;


        sectorTrigger.setAttribute(
            'aria-expanded',
            'false'
        );


        sectorIcon?.classList.remove(
            'company-register__select-icon--open'
        );

    };


    if (
        sectorDropdown &&
        sectorTrigger &&
        sectorMenu &&
        sectorInput &&
        sectorLabel
    ) {

        sectorMenu.innerHTML = '';


        sectorOptions.forEach((option) => {

            const optionButton =
                document.createElement('button');


            optionButton.type = 'button';

            optionButton.className =
                'company-register__sector-option';

            optionButton.dataset.sectorValue =
                option.value;

            optionButton.textContent =
                option.label;


            optionButton.addEventListener(
                'click',
                () => {

                    sectorInput.value =
                        option.value;


                    sectorLabel.textContent =
                        option.label;


                    sectorLabel.classList.remove(
                        'company-register__sector-placeholder'
                    );


                    sectorMenu
                        .querySelectorAll(
                            '.company-register__sector-option'
                        )
                        .forEach((item) => {

                            item.classList.remove(
                                'company-register__sector-option--selected'
                            );

                        });


                    optionButton.classList.add(
                        'company-register__sector-option--selected'
                    );


                    if (customSector) {

                        if (option.value === 'other') {

                            customSector.hidden = false;

                            customSector.required = true;

                        } else {

                            customSector.hidden = true;

                            customSector.required = false;

                            customSector.value = '';

                        }

                    }


                    sectorTrigger.setAttribute(
                        'aria-invalid',
                        'false'
                    );


                    closeSectorDropdown();

                }
            );


            sectorMenu.appendChild(
                optionButton
            );

        });


        sectorTrigger.addEventListener(
            'click',
            () => {

                const isOpen =
                    sectorTrigger.getAttribute(
                        'aria-expanded'
                    ) === 'true';


                if (isOpen) {

                    closeSectorDropdown();

                } else {

                    openSectorDropdown();

                }

            }
        );


        document.addEventListener(
            'click',
            (event) => {

                if (
                    event.target instanceof Node &&
                    !sectorDropdown.contains(event.target)
                ) {

                    closeSectorDropdown();

                }

            }
        );


        document.addEventListener(
            'keydown',
            (event) => {

                if (event.key === 'Escape') {

                    closeSectorDropdown();

                }

            }
        );

    }


    /* =====================================================
       FORMULARIO EMPRESA
    ===================================================== */

    const companyForm =
        registerPage.querySelector(
            '[data-company-form]'
        );

    const mainStage =
        registerPage.querySelector(
            '[data-register-main]'
        );

    const membershipStage =
        registerPage.querySelector(
            '[data-register-membership]'
        );


    companyForm?.addEventListener(
        'submit',
        (event) => {

            event.preventDefault();


            if (!companyForm.checkValidity()) {

                companyForm.reportValidity();

                return;
            }


            /* Sector obligatorio */
            if (
                sectorInput &&
                !sectorInput.value
            ) {

                sectorTrigger?.setAttribute(
                    'aria-invalid',
                    'true'
                );


                openSectorDropdown();

                sectorTrigger?.focus();

                return;
            }


            /* Contraseñas */
            const password =
                companyForm.querySelector(
                    '[name="password"]'
                );

            const passwordConfirmation =
                companyForm.querySelector(
                    '[name="password_confirmation"]'
                );


            if (
                password &&
                passwordConfirmation &&
                password.value !== passwordConfirmation.value
            ) {

                passwordConfirmation.setCustomValidity(
                    'Las contraseñas no coinciden.'
                );

                passwordConfirmation.reportValidity();

                return;
            }


            passwordConfirmation?.setCustomValidity('');


            /* Mostrar membresías */
            mainStage?.classList.add(
                'register-flow__stage--main-hidden'
            );


            membershipStage?.classList.add(
                'register-flow__stage--membership-active'
            );

        }
    );


    /* =====================================================
       QUITAR ERROR DE CONTRASEÑA EMPRESA
    ===================================================== */

    const companyPasswordConfirmation =
        companyForm?.querySelector(
            '[name="password_confirmation"]'
        );


    companyPasswordConfirmation?.addEventListener(
        'input',
        () => {

            companyPasswordConfirmation.setCustomValidity('');

        }
    );


    /* =====================================================
       MEMBRESÍA → REGISTRO EMPRESA
    ===================================================== */

    const membershipBack =
        registerPage.querySelector(
            '[data-membership-back]'
        );


    membershipBack?.addEventListener(
        'click',
        () => {

            mainStage?.classList.remove(
                'register-flow__stage--main-hidden'
            );


            membershipStage?.classList.remove(
                'register-flow__stage--membership-active'
            );

        }
    );


    /* =====================================================
       SELECCIÓN DE MEMBRESÍA
    ===================================================== */

    let selectedMembership = null;


    const membershipCards =
        registerPage.querySelectorAll(
            '[data-membership]'
        );


    membershipCards.forEach((card) => {

        card.addEventListener(
            'click',
            () => {

                membershipCards.forEach(
                    (item) => {

                        item.classList.remove(
                            'company-membership__card--selected'
                        );

                    }
                );


                card.classList.add(
                    'company-membership__card--selected'
                );


                selectedMembership =
                    card.dataset.membership;

            }
        );

    });


    /* =====================================================
        FORMULARIO DE PAGO

        POR AHORA SOLAMENTE SIMULADO.
        ===================================================== */

        const paymentForm =
            registerPage.querySelector(
                '[data-membership-payment-form]'
            );


        paymentForm?.addEventListener(
            'submit',
            (event) => {

                event.preventDefault();


                if (!selectedMembership) {

                    console.warn(
                        'Selecciona una membresía antes de continuar.'
                    );

                    membershipCards[0]?.focus();

                    return;
                }


                if (!paymentForm.checkValidity()) {

                    paymentForm.reportValidity();

                    return;
                }


                const companyUrl =
                    registerPage.dataset.companyUrl;


                if (!companyUrl) {

                    console.error(
                        'No se encontró la URL de la interfaz empresarial.'
                    );

                    return;
                }


                window.location.href = companyUrl;

            }
        );


    /* =====================================================
       ESTADO INICIAL
    ===================================================== */

    showRegisterScreen('account-type');

    showStudentStep('data');

    closeSectorDropdown();

}


/* =====================================================
   INICIALIZACIÓN
===================================================== */

if (document.readyState === 'loading') {

    document.addEventListener(
        'DOMContentLoaded',
        initRegisterPage
    );

} else {

    initRegisterPage();

}