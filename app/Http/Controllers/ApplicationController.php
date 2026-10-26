<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    // ------- solicitudes de la empresa -------

    // muestra las postulaciones que recibio la empresa
    public function companyIndex()
    {
        // toma el id de la empresa con sesion
        $companyId = (string) auth()->id();

        // busca las postulaciones de esa empresa
        $companyApplications = Application::where(
            'company_user_id',
            $companyId
        )->get();

        // busca las vacantes de esa empresa
        $vacancies = Vacancy::where('company_user_id', $companyId)
            ->get()
            ->keyBy(function ($vacancy) {
                return (string) $vacancy->getKey();
            });

        // prepara los datos que necesita la vista
        $applications = $companyApplications->map(
            function ($application) use ($vacancies) {
                $vacancy = $vacancies->get(
                    (string) $application->vacancy_id
                );

                return [
                    'id' => (string) $application->getKey(),
                    'vacancyId' => (string) $application->vacancy_id,
                    'vacancyTitle' => $vacancy?->title ?? 'Vacante no disponible',
                    'name' => $application->full_name,
                    'email' => $application->email,
                    'phone' => $application->phone,
                    'location' => $application->location,
                    'status' => $application->status,
                    'cvPath' => $application->cv_path,
                    'cvName' => $application->cv_name,
                    'studentUserId' => (string) $application->student_user_id,
                ];
            }
        );

        return view('company.applications', compact('applications'));
    }

    // muestra la informacion de una postulacion
    public function show($id)
    {
        // busca la postulacion por su id
        $record = Application::findOrFail($id);

        // revisa que la solicitud sea de la empresa con sesion
        abort_unless(
            (string) $record->company_user_id === (string) auth()->id(),
            403
        );

        // busca al estudiante que se postulo
        $student = User::findOrFail($record->student_user_id);

        // prepara los datos para la vista del aplicante
        $application = [
            'id' => (string) $record->getKey(),
            'status' => $record->status,

            'student' => [
                'avatar' => $student->avatar_path
                    ? Storage::disk('public')->url($student->avatar_path)
                    : null,

                'fullName' => $record->full_name,
                'email' => $record->email,
                'location' => $record->location,
                'phone' => $record->phone,

                'birthDate' => $student->birth_date
                    ? $student->birth_date->format('d/m/Y')
                    : 'No especificada',

                'description' => $student->description,
            ],
        ];

        return view(
            'company.applicant-profile',
            compact('application')
        );
    }

    // permite descargar el cv actual del estudiante
    public function cv($id)
    {
        // busca la postulacion
        $application = Application::findOrFail($id);

        // revisa que pertenezca a la empresa con sesion
        abort_unless(
            (string) $application->company_user_id === (string) auth()->id(),
            403
        );

        // busca al estudiante
        $student = User::findOrFail($application->student_user_id);

        // revisa que exista el archivo del cv
        abort_unless(
            $student->cv_path
                && Storage::disk('local')->exists($student->cv_path),
            404
        );

        // envia el archivo para descargar
        return Storage::disk('local')->download(
            $student->cv_path,
            $student->cv_name ?? 'CV.pdf'
        );
    }

    // cambia el estado de una postulacion
    public function status(Request $request, $id)
    {
        // solo acepta estos dos estados
        $validated = $request->validate([
            'status' => ['required', 'in:accepted,rejected'],
        ]);

        // busca la postulacion
        $application = Application::findOrFail($id);

        // revisa que sea de la empresa con sesion
        abort_unless(
            (string) $application->company_user_id === (string) auth()->id(),
            403
        );

        // guarda el nuevo estado
        $application->status = $validated['status'];
        $application->save();

        return redirect()
            ->route('company.applications.show', $id)
            ->with('success', 'Estado de la solicitud actualizado.');
    }

    // ------- postulacion desde la pagina -------

    // recibe la postulacion que hace el estudiante
    public function storeStudent(Request $request, string $id)
    {
        // obtiene al estudiante que tiene la sesion abierta
        $student = $request->user();

        // busca la vacante y revisa que este publicada
        $vacancy = Vacancy::where('_id', $id)
            ->where('status', 'published')
            ->firstOrFail();

        // busca la empresa que publico esa vacante
        $company = User::where('_id', $vacancy->company_user_id)
            ->where('role', 'company')
            ->firstOrFail();

        // revisa si el estudiante ya se postulo
        $alreadyApplied = Application::where('vacancy_id', $id)
            ->where('student_user_id', (string) $student->getKey())
            ->exists();

        // si ya se postulo, no crea otra solicitud
        if ($alreadyApplied) {
            return redirect()
                ->route('student.vacancies.show', $id)
                ->with(
                    'success',
                    'Ya enviaste una postulación a esta vacante.'
                );
        }

        // revisa los datos enviados en el formulario
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'location' => ['required', 'string', 'max:255'],
            'cv' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ], [
            'full_name.required' => 'Escribe tu nombre completo.',
            'email.required' => 'Escribe tu correo electrónico.',
            'email.email' => 'Escribe un correo electrónico válido.',
            'phone.required' => 'Escribe tu número telefónico.',
            'location.required' => 'Escribe tu ubicación.',
            'cv.mimes' => 'El CV debe ser un archivo PDF.',
            'cv.max' => 'El CV no debe superar los 5 MB.',
        ]);

        // ------- guardar el cv -------

        // si se subio un cv nuevo, tambien se guarda en el perfil
        if ($request->hasFile('cv')) {
            // guarda la ruta anterior para borrarla despues
            $oldCvPath = $student->cv_path;

            // guarda el archivo nuevo
            $student->cv_path = $request->file('cv')
                ->store('cvs', 'local');

            // guarda el nombre original del archivo
            $student->cv_name = $request->file('cv')
                ->getClientOriginalName();

            $student->save();

            // borra el cv anterior si existia
            if ($oldCvPath) {
                Storage::disk('local')->delete($oldCvPath);
            }
        }

        // ------- guardar la postulacion -------

        // crea la solicitud con los datos del estudiante y la vacante
        Application::create([
            'vacancy_id' => (string) $vacancy->getKey(),
            'company_user_id' => (string) $company->getKey(),
            'student_user_id' => (string) $student->getKey(),

            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'location' => $data['location'],

            'cv_path' => $student->cv_path,
            'cv_name' => $student->cv_name,
            'status' => 'pending',
        ]);

        // vuelve al detalle y muestra el mensaje
        return redirect()
            ->route('student.vacancies.show', $id)
            ->with('success', 'Postulación exitosa.');
    }

    // ------- postulaciones desde la api -------

    // crea una postulacion desde la api administrativa
    public function store(Request $request)
    {
        // revisa los datos que llegaron
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

        // toda postulacion nueva empieza pendiente
        $validated['status'] = 'pending';

        $application = Application::create($validated);

        return response()->json($application, 201);
    }

    // devuelve todas las postulaciones
    public function index()
    {
        return response()->json(Application::all(), 200);
    }

    // actualiza una postulacion
    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);

        $application->update($request->all());

        return response()->json($application, 200);
    }

    // elimina una postulacion
    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        $application->delete();

        return response()->json([
            'message' => 'Postulación eliminada',
        ], 200);
    }
}