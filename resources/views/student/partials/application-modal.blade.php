@php
    $studentFullName = trim(implode(' ', array_filter([
        $student->first_name,
        $student->paternal_last_name,
        $student->maternal_last_name,
    ])));
@endphp

    {{--  MODAL DE REVISIÓN  --}}

    <x-review-modal title="Revisión de datos para postulación">

        <x-slot:description>

            <span>
                Estos son los datos que se enviarán a la empresa.
                Puedes modificarlos únicamente para esta postulación.
            </span>

        </x-slot:description>


        <form
            id="application-review-form"
            data-application-form
            action="{{ route('student.applications.store', $vacancy['id']) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            <input type="hidden" name="vacancy_id" value="{{ old('vacancy_id', $vacancy['id']) }}">
            @if($errors->any())
                <div class="flow-feedback flow-feedback--error" role="alert">
                    <p>Revisa los datos de tu postulación:</p>
                    <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            {{-- =====================================
                NOMBRE
            ====================================== --}}

            <div class="review-modal__field">

                <label
                    for="application-full-name"
                    class="review-modal__field-label"
                >
                    Nombre completo
                </label>

                <input
                    id="application-full-name"
                    type="text"
                    name="full_name"
                    class="review-modal__field-input"
                    value="{{ old('full_name', $studentFullName) }}"
                    required
                >

            </div>


            {{-- =====================================
                CORREO
            ====================================== --}}

            <div class="review-modal__field">

                <label
                    for="application-email"
                    class="review-modal__field-label"
                >
                    Correo electrónico
                </label>

                <input
                    id="application-email"
                    type="email"
                    name="email"
                    class="review-modal__field-input"
                    value="{{ old('email', $student->email) }}"
                    required
                >

            </div>


            {{-- =====================================
                TELÉFONO
            ====================================== --}}

            <div class="review-modal__field">

                <label
                    for="application-phone"
                    class="review-modal__field-label"
                >
                    Número telefónico
                </label>

                <input
                    id="application-phone"
                    type="tel"
                    name="phone"
                    class="review-modal__field-input"
                    value="{{ old('phone', $student->phone) }}"
                    required
                >

            </div>


            {{-- =====================================
                UBICACIÓN
            ====================================== --}}

            <div class="review-modal__field">

                <label
                    for="application-location"
                    class="review-modal__field-label"
                >
                    Ubicación
                </label>

                <input
                    id="application-location"
                    type="text"
                    name="location"
                    class="review-modal__field-input"
                    value="{{ old('location', $student->city ?? $student->state ?? '') }}"
                    required
                >

            </div>


            {{-- =====================================
                CV
            ====================================== --}}

            <div class="review-modal__field">

                <p class="review-modal__field-label">
                    CV
                </p>


                <label
                    for="application-cv"
                    class="review-modal__file"
                >

                    <span
                        class="review-modal__file-name"
                        data-cv-name
                    >
                        {{ $student->cv_name ?: 'Seleccionar CV en PDF' }}
                    </span>

                    <span class="review-modal__file-action">
                        Cambiar archivo
                    </span>

                </label>


                <input
                    id="application-cv"
                    type="file"
                    name="cv"
                    accept=".pdf,application/pdf"
                    class="review-modal__file-input"
                    data-cv-input
                >


                <p
                    class="review-modal__file-message"
                    data-cv-message
                    hidden
                ></p>

            </div>

        </form>


        <x-slot:actions>

            <button
                type="submit"
                form="application-review-form"
                class="review-modal__primary-button"
                data-application-confirm
            >
                Confirmar postulación
            </button>

        </x-slot:actions>

    </x-review-modal>
