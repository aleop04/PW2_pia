<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    // POST: Crear un nuevo plan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'vacancy_limit' => 'nullable|integer',
            'priority' => 'required|integer',
            'benefits' => 'required|array',
            'active' => 'boolean'
        ]);

        $membership = Membership::create($validated);
        return response()->json($membership, 201);
    }

    // GET: Obtener todos los planes
    public function index()
    {
        return response()->json(Membership::all(), 200);
    }

    // PUT: Actualizar un plan
    public function update(Request $request, $id)
    {
        $membership = Membership::findOrFail($id);
        $membership->update($request->all());
        return response()->json($membership, 200);
    }

    // DELETE: Eliminar un plan
    public function destroy($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->delete();
        return response()->json(['message' => 'Plan eliminado'], 200);
    }
}