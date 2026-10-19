<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // POST: Crear una postulación
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

        $application = Application::create($validated);
        return response()->json($application, 201);
    }

    // GET: Obtener todas las postulaciones
    public function index()
    {
        return response()->json(Application::all(), 200);
    }

    // PUT: Actualizar una postulación (ej. cambiar el status)
    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $application->update($request->all());
        return response()->json($application, 200);
    }

    // DELETE: Eliminar una postulación
    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        $application->delete();
        return response()->json(['message' => 'Postulación eliminada'], 200);
    }
}