<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    // POST: Crear una vacante
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_user_id' => 'required|string',
            'title' => 'required|string',
            'modality' => 'required|string', // remote, hybrid, onsite
            'location' => 'required|string',
            'stay_duration' => 'required|string',
            'salary_fixed' => 'nullable|numeric',
            'periodicity' => 'required|string', // weekly, monthly
            'description' => 'required|string',
            'benefits' => 'array',
        ]);

        $validated['status'] = 'published';
        
        $vacancy = Vacancy::create($validated);
        return response()->json($vacancy, 201);
    }

    // GET: Obtener todas las vacantes
    public function index()
    {
        return response()->json(Vacancy::all(), 200);
    }

    // PUT: Actualizar una vacante
    public function update(Request $request, $id)
    {
        $vacancy = Vacancy::findOrFail($id);
        $vacancy->update($request->all());
        return response()->json($vacancy, 200);
    }

    // DELETE: Eliminar una vacante
    public function destroy($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        $vacancy->delete();
        return response()->json(['message' => 'Vacante eliminada'], 200);
    }
}