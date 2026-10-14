<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vacancy;
use App\Models\Application;
use Illuminate\Http\Request;

class CompanyVacancyController extends Controller
{
    public function dashboard(Request $request)
    {
        $id = (string) $request->user()->getKey();
        $vacancyCount = Vacancy::where('company_user_id', $id)->where('status', 'published')->count();
        $records = Application::where('company_user_id', $id)->latest()->get();
        $applicationCount = $records->count();
        $applications = $records->take(5)->map(fn (Application $record) => [
            'name' => $record->full_name,
            'date' => $record->created_at?->format('d/m/Y'),
            'cv' => $record->cv_name,
            'status' => ['pending' => 'Pendiente', 'accepted' => 'Aceptada', 'rejected' => 'Rechazada'][$record->status] ?? $record->status,
            'statusClass' => $record->status,
        ]);

        return view('company.index', compact('vacancyCount', 'applicationCount', 'applications'));
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
