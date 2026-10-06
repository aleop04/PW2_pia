<div
    class="delete-vacancy-modal__overlay"
    data-delete-vacancy-modal
    hidden
>

    <div
        class="delete-vacancy-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="delete-vacancy-title"
        style="background-image: url('{{ asset('images/deletevacmodal.png') }}');"
    >

        <div class="delete-vacancy-modal__content">

            <h2
                id="delete-vacancy-title"
                class="delete-vacancy-modal__title"
            >
                Estás por eliminar una vacante
            </h2>


            <p class="delete-vacancy-modal__description">
                Estás por borrar una vacante del sitio.
                Esta ya no podrá ser vista por los usuarios
                ni podrán postularse. ¿Deseas continuar?
            </p>


            <div class="delete-vacancy-modal__actions">

                <button
                    type="button"
                    class="
                        delete-vacancy-modal__button
                        delete-vacancy-modal__button--cancel
                    "
                    data-delete-cancel
                >
                    Cancelar
                </button>


                <button
                    type="button"
                    class="
                        delete-vacancy-modal__button
                        delete-vacancy-modal__button--delete
                    "
                    data-delete-confirm
                >
                    Eliminar
                </button>

            </div>

        </div>

    </div>

</div>