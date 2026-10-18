<?php

namespace App\Http\Controllers;

use App\Models\Application;
<<<<<<< HEAD
use App\Models\Bookmark;
=======
>>>>>>> origin/main
use App\Models\User;
use App\Models\Vacancy;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function student(Request $request)
    {
        $user = $request->user();

        $studentProfile = StudentProfile::where(
            'user_id',
            (string) $user->getKey()
        )->first();

        $student = [
            'firstName' => $user->first_name,
            'paternalSurname' => $user->paternal_last_name,
            'maternalSurname' => $user->maternal_last_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'birthDate' => $user->birth_date?->format('d/m/Y'),
            'birthDateValue' => $user->birth_date?->format('Y-m-d'),
            'avatar' => $user->avatar_path
                ? Storage::disk('public')->url($user->avatar_path)
                : null,
            'hasCv' => !empty($user->cv_path),
            'hasKardex' => !empty($studentProfile?->kardex_path),
        ];

        $applications = Application::where(
            'student_user_id',
            (string) $user->getKey()
        )
            ->latest()
            ->get()
            ->map(function (Application $application) {
                $vacancy = Vacancy::find($application->vacancy_id);

                if (!$vacancy || $vacancy->status !== 'published') {
                    return null;
                }

                $company = User::find($vacancy->company_user_id);

                if (!$company) {
                    return null;
                }

                return $vacancy->card($company);
            })
            ->filter()
            ->values();

        $savedVacancies = Bookmark::where(
            'student_user_id',
            (string) $user->getKey()
        )
            ->latest()
            ->get()
            ->map(function (Bookmark $bookmark) {
                $vacancy = Vacancy::where('_id', $bookmark->vacancy_id)
                    ->where('status', 'published')
                    ->first();

                $company = $vacancy
                    ? User::find($vacancy->company_user_id)
                    : null;

                return $company ? $vacancy->card($company) : null;
            })
            ->filter()
            ->values();

        return view('student.profile', compact(
            'student',
            'applications',
            'savedVacancies'
        return view('student.profile', compact(
            'student',
            'applications'
        ));
    }

    public function updateStudent(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'paternal_last_name' => ['required', 'string', 'max:100'],
            'maternal_last_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'birth_date' => ['required', 'date', 'before:today'],
            'password' => ['nullable', 'string', 'min:8', 'max:72', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'cv' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'kardex' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        $user = $request->user();

        $user->fill([
            'first_name' => $data['first_name'],
            'paternal_last_name' => $data['paternal_last_name'],
            'maternal_last_name' => $data['maternal_last_name'],
            'phone' => $data['phone'],
            'birth_date' => $data['birth_date'],
        ]);

        if (!empty($data['password'])) {
            $user->password = $data['password'];
        }

        $oldAvatar = $user->avatar_path;
        $oldCv = $user->cv_path;

        if ($request->hasFile('avatar')) {
            $user->avatar_path = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->hasFile('cv')) {
            $user->cv_path = $request->file('cv')->store('cvs', 'local');
            $user->cv_name = $request->file('cv')->getClientOriginalName();
        }

        $user->save();

        if ($request->hasFile('avatar') && $oldAvatar) {
            Storage::disk('public')->delete($oldAvatar);
        }

        if ($request->hasFile('cv') && $oldCv) {
            Storage::disk('local')->delete($oldCv);
        }

        $studentProfile = StudentProfile::firstOrNew([
            'user_id' => (string) $user->getKey(),
        ]);

        if ($request->hasFile('kardex')) {
            $oldKardex = $studentProfile->kardex_path;

            $studentProfile->kardex_path = $request
                ->file('kardex')
                ->store('kardex', 'local');

            $studentProfile->kardex_original_name = $request
                ->file('kardex')
                ->getClientOriginalName();

            $studentProfile->save();

            if ($oldKardex) {
                Storage::disk('local')->delete($oldKardex);
            }
        }

        return back()->with('success', 'Perfil estudiantil actualizado.');
    }

    public function cv(Request $request)
    {
        $user = $request->user();
        abort_unless($user->cv_path && Storage::disk('local')->exists($user->cv_path), 404);

        return Storage::disk('local')->download($user->cv_path, $user->cv_name ?? 'CV.pdf');
    }

    public function kardex(Request $request)
    {
        $studentProfile = StudentProfile::where(
            'user_id',
            (string) $request->user()->getKey()
        )->firstOrFail();

        abort_unless(
            $studentProfile->kardex_path &&
            Storage::disk('local')->exists($studentProfile->kardex_path),
            404
        );

        return Storage::disk('local')->download(
            $studentProfile->kardex_path,
            $studentProfile->kardex_original_name ?? 'Kardex.pdf'
        );
    }

    public function company(Request $request)
    {
        return view('company.profile', ['user' => $request->user()]);
    }

    public function updateCompany(Request $request)
    {
        $data = $request->validate([
            'description' => ['nullable', 'string', 'max:3000'],
            'state' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
        ]);

        $user = $request->user();
        $oldLogo = $user->logo_path;
        $user->fill(collect($data)->only(['description', 'state', 'city'])->all());
        if ($request->hasFile('logo')) {
            $user->logo_path = $request->file('logo')->store('company-logos', 'public');
        }
        $user->save();
        if ($request->hasFile('logo') && $oldLogo) Storage::disk('public')->delete($oldLogo);

        return back()->with('success', 'Perfil empresarial guardado.');
    }
}
