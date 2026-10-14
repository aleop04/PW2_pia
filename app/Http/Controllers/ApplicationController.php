<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    private function owned(Request $request, string $id): Application
    {
        return Application::where('company_user_id', (string) $request->user()->getKey())
            ->where('_id', $id)->firstOrFail();
    }

    public function store(Request $request, string $id)
    {
        $vacancy = Vacancy::where('_id', $id)->where('status', 'published')->firstOrFail();
        $student = $request->user();

        if (Application::where('vacancy_id', $id)
            ->where('student_user_id', (string) $student->getKey())->exists()) {
            return back()->withErrors(['application' => 'Ya te postulaste a esta vacante.']);
        }

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'location' => ['required', 'string', 'max:160'],
            'cv' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        $path = $student->cv_path;
        $name = $student->cv_name;

        if ($request->hasFile('cv')) {
            $path = $request->file('cv')->store('cvs', 'local');
            $name = $request->file('cv')->getClientOriginalName();
        }

        if (!$path || !Storage::disk('local')->exists($path)) {
            return back()->withErrors(['cv' => 'Sube tu CV en PDF para postularte.']);
        }

        try {
            Application::create([
                'vacancy_id' => $id,
                'company_user_id' => (string) $vacancy->company_user_id,
                'student_user_id' => (string) $student->getKey(),
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'location' => $data['location'],
                'cv_path' => $path,
                'cv_name' => $name,
                'status' => 'pending',
            ]);
        } catch (\Throwable $error) {
            if ($request->hasFile('cv')) {
                Storage::disk('local')->delete($path);
            }
            if (str_contains($error->getMessage(), 'E11000')) {
                return back()->withErrors(['application' => 'Ya te postulaste a esta vacante.']);
            }
            throw $error;
        }

        if ($request->hasFile('cv')) {
            $student->update(['cv_path' => $path, 'cv_name' => $name]);
        }

        return redirect()->route('student.applications.index')
            ->with('success', 'Postulación exitosa.');
    }

    public function index(Request $request)
    {
        $records = Application::where('company_user_id', (string) $request->user()->getKey())
            ->latest()->get();
        $applications = $records->map(function (Application $record) {
            $vacancy = Vacancy::find($record->vacancy_id);
            return [
                'id' => (string) $record->getKey(),
                'studentId' => $record->student_user_id,
                'name' => $record->full_name,
                'vacancyId' => $record->vacancy_id,
                'vacancyTitle' => $vacancy?->title ?? 'Vacante retirada',
            ];
        });

        return view('company.applications', compact('applications'));
    }

    public function studentIndex(Request $request)
    {
        $applications = Application::where('student_user_id', (string) $request->user()->getKey())
            ->latest()->get()->map(function (Application $record) {
                $vacancy = Vacancy::find($record->vacancy_id);
                $company = $vacancy ? User::find($vacancy->company_user_id) : null;

                return [
                    'vacancy_id' => $record->vacancy_id,
                    'title' => $vacancy?->title ?? 'Vacante retirada',
                    'company' => $company?->company_name ?? 'Empresa no disponible',
                    'date' => $record->created_at?->format('d/m/Y'),
                    'status' => $record->status,
                    'available' => $vacancy?->status === 'published' && $company !== null,
                ];
            });

        return view('student.applications', compact('applications'));
    }

    public function show(Request $request, string $id)
    {
        $record = $this->owned($request, $id);
        $student = User::find($record->student_user_id);
        $application = [
            'id' => (string) $record->getKey(),
            'status' => $record->status,
            'student' => [
                'id' => $record->student_user_id,
                'fullName' => $record->full_name,
                'email' => $record->email,
                'location' => $record->location,
                'phone' => $record->phone,
                'birthDate' => $student?->birth_date?->format('d/m/Y') ?? '—',
                'description' => $student?->description,
                'avatar' => $student?->avatar_path ? Storage::disk('public')->url($student->avatar_path) : null,
                'cv' => $record->cv_name,
            ],
        ];

        return view('company.applicant-profile', compact('application'));
    }

    public function cv(Request $request, string $id)
    {
        $application = $this->owned($request, $id);
        abort_unless(Storage::disk('local')->exists($application->cv_path), 404);

        return Storage::disk('local')->download($application->cv_path, $application->cv_name);
    }

    public function status(Request $request, string $id)
    {
        $data = $request->validate(['status' => ['required', 'in:accepted,rejected']]);
        $this->owned($request, $id)->update($data);

        return redirect()->route('company.applications.show', $id)
            ->with('success', 'Estado de la postulación actualizado.');
    }
}
