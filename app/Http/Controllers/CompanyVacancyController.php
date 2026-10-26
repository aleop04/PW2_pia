<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\CompanyProfileView;
use App\Models\CompanyReview;
use App\Models\Subscription;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CompanyVacancyController extends Controller
{
    public function dashboard(Request $request)
    {
        $id = (string) $request->user()->getKey();

        /* Todas las solicitudes recibidas por esta empresa */
        $records = Application::where('company_user_id', $id)
            ->latest()
            ->get();

        /* Estudiantes únicos que han visitado el perfil */
        $profileVisitorCount = CompanyProfileView::where(
            'company_user_id',
            $id
        )
            ->pluck('student_user_id')
            ->filter()
            ->unique()
            ->count();

        /* Alcance total: Cada registro representa como máximo una visita por estudiante, empresa y día */
        $profileReachCount = CompanyProfileView::where(
            'company_user_id',
            $id
        )->count();

        /* Estudiantes únicos que se han postulado */
        $applicationUserCount = $records
            ->pluck('student_user_id')
            ->filter()
            ->unique()
            ->count();

        /* Estudiantes únicos que han valorado a la empresa */
        $reviewerCount = CompanyReview::where(
            'company_user_id',
            $id
        )
            ->pluck('student_user_id')
            ->filter()
            ->unique()
            ->count();

        /* Últimas solicitudes para la tabla */
        $applications = $records
            ->take(4)
            ->map(fn (Application $record) => [
                'name' => $record->full_name,

                'date' => $record->created_at?->format('d/m/Y'),

                'cv' => $record->cv_name,

                'status' => [
                    'pending' => 'Pendiente',
                    'accepted' => 'Aceptada',
                    'rejected' => 'Rechazada',
                ][$record->status] ?? $record->status,

                'statusClass' => $record->status,
            ]);

        return view('company.index', compact(
            'profileVisitorCount',
            'profileReachCount',
            'applicationUserCount',
            'reviewerCount',
            'applications'
        ));
    }

    private function owned(Request $request, string $id): Vacancy
    {
        return Vacancy::where('company_user_id', (string) $request->user()->getKey())
            ->where('_id', $id)->firstOrFail();
    }

    private function fields(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'modality' => ['required', 'in:Remoto,Presencial,Híbrido'],
            'location' => ['required', 'string', 'max:160'],
            'stay_duration' => ['required', 'in:3 meses,6 meses'],
            'salary_fixed' => ['required', 'integer', 'min:1'],
            'periodicity' => ['required', 'in:Por mes,Por quincena,Por semana'],
            'description' => ['required', 'string', 'max:5000'],
            'benefits' => ['required', 'array', 'min:1'],
            'benefits.*' => ['string', 'max:120'],
        ]);
    }

    public function index(Request $request)
    {
        $company = $request->user();
        $vacancies = Vacancy::where('company_user_id', (string) $company->getKey())
            ->where('status', 'published')->latest()->get()
            ->map(fn (Vacancy $vacancy) => $vacancy->card($company));

        return view('company.vacancies', compact('vacancies'));
    }

    public function store(Request $request)
    {
        $fields = $this->fields($request);
        $companyId = (string) $request->user('web')->getKey();
        $subscription = Subscription::where('company_user_id', $companyId)
            ->where('payment_status', 'paid')->where('status', 'active')
            ->where('started_at', '<=', now())->where('ended_at', '>', now())->latest('started_at')->first();
        if (! $subscription) {
            throw ValidationException::withMessages(['membership' => 'Necesitas una membresía pagada y vigente para publicar vacantes.']);
        }
        $limit = $subscription->membership_vacancy_limit;
        if ($limit !== null && Vacancy::where('company_user_id', $companyId)->where('status', 'published')->count() >= $limit) {
            throw ValidationException::withMessages(['membership' => 'Alcanzaste el límite de vacantes publicadas de tu membresía.']);
        }
        $fields['company_user_id'] = (string) $request->user()->getKey();
        $fields['status'] = 'published';
        $vacancy = Vacancy::create($fields);

        return redirect()->route('company.vacancies.show', $vacancy->getKey())
            ->with('success', 'Vacante publicada.');
    }

    public function show(Request $request, string $id)
    {
        $vacancy = $this->owned($request, $id)->card($request->user());

        return view('company.vacancy-detail', compact('vacancy'));
    }

    public function edit(Request $request, string $id)
    {
        $record = $this->owned($request, $id);
        $vacancy = $record->card($request->user());

        return view('company.vacancy-edit', compact('vacancy'));
    }

    public function update(Request $request, string $id)
    {
        $record = $this->owned($request, $id);
        $record->update($this->fields($request));

        return redirect()->route('company.vacancies.show', $record->getKey())
            ->with('success', 'Vacante actualizada.');
    }

    public function destroy(Request $request, string $id)
    {
        $this->owned($request, $id)->update(['status' => 'closed']);

        return redirect()->route('company.vacancies.index')
            ->with('success', 'Vacante retirada de la publicación.');
    }
}
