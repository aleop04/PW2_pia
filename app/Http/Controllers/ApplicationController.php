<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Vacancy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    // mostrar solicitudes en la interfaz empresarial
    public function companyIndex()
    {
        $companyId = (string) auth()->id();

        // obtener postulaciones de esta empresa
        $companyApplications = Application::where(
            'company_user_id',
            $companyId
        )->get();

        // obtener vacantes de esta empresa
        $vacancies = Vacancy::where(
            'company_user_id',
            $companyId
        )
            ->get()
            ->keyBy(function ($vacancy) {
                return (string) $vacancy->getKey();
            });

        // preparar datos para la vista
        $applications = $companyApplications->map(
            function ($application) use ($vacancies) {

                $vacancy = $vacancies->get(
                    (string) $application->vacancy_id
                );

                return [
                    'id' => (string) $application->getKey(),

                    'vacancyId' =>
                        (string) $application->vacancy_id,

                    'vacancyTitle' =>
                        $vacancy?->title ?? 'Vacante no disponible',

                    'name' =>
                        $application->full_name,

                    'email' =>
                        $application->email,

                    'phone' =>
                        $application->phone,

                    'location' =>
                        $application->location,

                    'status' =>
                        $application->status,

                    'cvPath' =>
                        $application->cv_path,

                    'cvName' =>
                        $application->cv_name,

                    'studentUserId' =>
                        (string) $application->student_user_id,
                ];
            }
        );

        return view(
            'company.applications',
            compact('applications')
        );
    }


    // mostrar perfil de un aplicante
    public function show($id)
    {
        $record = Application::findOrFail($id);

        // comprobar que la solicitud pertenece a esta empresa
        abort_unless(
            (string) $record->company_user_id ===
            (string) auth()->id(),
            403
        );

        // buscar al estudiante
        $student = User::findOrFail(
            $record->student_user_id
        );

        // preparar los datos como los espera applicant-profile.blade.php
        $application = [
            'id' => (string) $record->getKey(),

            'status' =>
                $record->status,

            'student' => [

                'avatar' =>
                    $student->avatar_path
                        ? Storage::disk('public')
                            ->url($student->avatar_path)
                        : null,

                'fullName' =>
                    $record->full_name,

                'email' =>
                    $record->email,

                'location' =>
                    $record->location,

                'phone' =>
                    $record->phone,

                'birthDate' =>
                    $student->birth_date
                        ? $student->birth_date->format('d/m/Y')
                        : 'No especificada',

                'description' =>
                    $student->description,
            ],
        ];

        return view(
            'company.applicant-profile',
            compact('application')
        );
    }


    // descargar CV del aplicante
    public function cv($id)
    {
        $application = Application::findOrFail($id);

        // comprobar que pertenece a esta empresa
        abort_unless(
            (string) $application->company_user_id ===
            (string) auth()->id(),
            403
        );

        // buscar al estudiante
        $student = User::findOrFail(
            $application->student_user_id
        );

        // usar el CV guardado actualmente en el perfil
        abort_unless(
            $student->cv_path &&
            Storage::disk('local')->exists($student->cv_path),
            404
        );

        return Storage::disk('local')->download(
            $student->cv_path,
            $student->cv_name ?? 'CV.pdf'
        );
    }


    // cambiar estado de una solicitud
    public function status(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:accepted,rejected',
            ],
        ]);

        $application = Application::findOrFail($id);

        // comprobar que pertenece a esta empresa
        abort_unless(
            (string) $application->company_user_id ===
            (string) auth()->id(),
            403
        );

        $application->status =
            $validated['status'];

        $application->save();

        return redirect()
            ->route(
                'company.applications.show',
                $id
            )
            ->with(
                'success',
                'Estado de la solicitud actualizado.'
            );
    }


    // crear una postulación
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vacancy_id' => 'required|string',
            'company_user_id' => 'required|string',
            'student_user_id' => 'required|string',
            'full_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'location' => 'required|string',
            'cv_path' => 'nullable|string',
            'cv_name' => 'nullable|string',
        ]);

        $validated['status'] = 'pending';

        $application = Application::create(
            $validated
        );

        return response()->json(
            $application,
            201
        );
    }


    // obtener todas las postulaciones
    public function index()
    {
        return response()->json(
            Application::all(),
            200
        );
    }


    // actualizar una postulación
    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);

        $application->update(
            $request->all()
        );

        return response()->json(
            $application,
            200
        );
    }


    // eliminar una postulación
    public function destroy($id)
    {
        $application = Application::findOrFail($id);

        $application->delete();

        return response()->json([
            'message' => 'Postulación eliminada'
        ], 200);
    }
}