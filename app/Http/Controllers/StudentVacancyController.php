<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Bookmark;
use App\Models\User;
use App\Models\CompanyProfileView;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentVacancyController extends Controller
{
    public function index(Request $request)
    {
        $appliedIds = Application::where('student_user_id', (string) $request->user()->getKey())
            ->pluck('vacancy_id')->map(fn ($id) => (string) $id)->all();
        $savedIds = Bookmark::where('student_user_id', (string) $request->user()->getKey())
            ->pluck('vacancy_id')->map(fn ($id) => (string) $id)->all();
        $vacancies = Vacancy::where('status', 'published')->latest()->get()
            ->map(function (Vacancy $vacancy) use ($appliedIds, $savedIds) {
                $company = User::find($vacancy->company_user_id);
                if (!$company) {
                    return null;
                }
                $card = $vacancy->card($company);
                $card['applied'] = in_array($card['id'], $appliedIds, true);
                $card['saved'] = in_array($card['id'], $savedIds, true);
                return $card;
            })->filter()->values();

        return view('student.index', compact('vacancies'));
    }

    public function show(Request $request, string $id)
    {
        $record = Vacancy::where('status', 'published')->where('_id', $id)->firstOrFail();
        $company = User::findOrFail($record->company_user_id);
        $vacancy = $record->card($company);
        $student = $request->user();
        $alreadyApplied = Application::where('vacancy_id', $id)
            ->where('student_user_id', (string) $student->getKey())->exists();
        $saved = Bookmark::where('vacancy_id', $id)
            ->where('student_user_id', (string) $student->getKey())
            ->exists();

        return view('student.vacancy-detail', compact('vacancy', 'student', 'alreadyApplied', 'saved'));
    }

    public function company(Request $request, string $id)
    {
        $record = User::where('role', 'company')->where('_id', $id)->firstOrFail();
        
        $studentId = (string) $request->user()->getKey();

        CompanyProfileView::firstOrCreate([
            'company_user_id' => (string) $record->getKey(),
            'student_user_id' => $studentId,
            'viewed_on' => now()->format('Y-m-d'),
        ]);

        $sectorLabels = [
            'technology' => 'Tecnología e Informática', 'health' => 'Salud y Medicina',
            'education' => 'Educación', 'finance' => 'Finanzas y Contabilidad',
            'engineering' => 'Ingeniería', 'business' => 'Administración y Negocios',
            'marketing' => 'Marketing y Publicidad', 'sales' => 'Ventas y Comercio',
            'rh' => 'Recursos Humanos', 'law' => 'Derecho',
            'architecture' => 'Arquitectura y Diseño', 'communication' => 'Comunicación y Medios',
            'tourism' => 'Turismo, Hotelería y Gastronomía', 'manufacturing' => 'Industria y Manufactura',
            'construction' => 'Construcción', 'logistics' => 'Logística y Transporte',
            'energy' => 'Energía y Medio Ambiente', 'agriculture' => 'Agricultura y Agroindustria',
            'science' => 'Ciencia e Investigación', 'government' => 'Sector Público y Gobierno',
        ];
        $company = [
            'id' => (string) $record->getKey(),
            'name' => $record->company_name,
            'logo' => $record->logo_path ? Storage::disk('public')->url($record->logo_path) : null,
            'rating' => null,
            'description' => $record->description ?: 'Esta empresa todavía no ha agregado su descripción.',
            'sector' => $record->custom_sector ?: ($sectorLabels[$record->sector] ?? $record->sector),
        ];
        $vacancies = Vacancy::where('company_user_id', $id)->where('status', 'published')
            ->latest()->get()->map(fn (Vacancy $item) => $item->card($record));
        $reviews = [];

        return view('student.company-profile', compact('company', 'vacancies', 'reviews'));
    }
}
