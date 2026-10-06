const changeMembershipPage =
    document.querySelector('[data-change-membership-page]')


if (changeMembershipPage) {

    /*  REGRESAR  */

    const membershipBack =
        changeMembershipPage.querySelector(
            '[data-membership-back]'
        )


    membershipBack?.addEventListener(
        'click',
        () => {

            const membershipUrl =
                changeMembershipPage.dataset.membershipUrl


            if (membershipUrl) {
                window.location.href = membershipUrl
            }

        }
    )


    /*  SELECCIÓN DE MEMBRESÍA  */

    let selectedMembership = null


    const membershipCards =
        changeMembershipPage.querySelectorAll(
            '[data-membership]'
        )


    membershipCards.forEach((card) => {

        card.addEventListener(
            'click',
            () => {

                membershipCards.forEach((item) => {

                    item.classList.remove(
                        'company-membership__card--selected'
                    )

                })


                card.classList.add(
                    'company-membership__card--selected'
                )


                selectedMembership =
                    card.dataset.membership

            }
        )

    })


    /* =====================================================
       FORMULARIO DE PAGO

       POR AHORA SOLAMENTE SIMULADO
    ===================================================== */

    const paymentForm =
        changeMembershipPage.querySelector(
            '[data-membership-payment-form]'
        )


    paymentForm?.addEventListener(
        'submit',
        (event) => {

            event.preventDefault()


            if (!selectedMembership) {

                console.warn(
                    'Selecciona una membresía antes de continuar.'
                )

                membershipCards[0]?.focus()

                return
            }


            if (!paymentForm.checkValidity()) {

                paymentForm.reportValidity()

                return
            }


            const membershipUrl =
                changeMembershipPage.dataset.membershipUrl


            if (!membershipUrl) {

                console.error(
                    'No se encontró la URL de membresía.'
                )

                return
            }


            window.location.href = membershipUrl

        }
    )

}