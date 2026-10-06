<a
    href="{{ route('company.applications.show', ['id' => $application['id']]) }}"
    class="applicant-card"
    data-application-card
    data-vacancy-id="{{ $application['vacancyId'] }}"
>

    <div class="applicant-card__content">

        <h3 class="applicant-card__vacancy-title">
            {{ $application['vacancyTitle'] }}
        </h3>

        <p class="applicant-card__applicant">

            <span>
                Postulado:
            </span>

            <span class="applicant-card__applicant-name">
                {{ $application['name'] }}
            </span>

        </p>

    </div>

</a>