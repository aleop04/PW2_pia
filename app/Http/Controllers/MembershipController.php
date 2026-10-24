<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MembershipController extends Controller
{
    // POST /api/memberships
    // Crea un nuevo plan de membresía.
    public function store(Request $request)
    {
        $request->merge([
            'code' => strtolower(trim((string) $request->input('code'))),
            'name' => trim((string) $request->input('name')),
        ]);

        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:20',
                'in:basic,plus,premium',
                Rule::unique(Membership::class, 'code'),
            ],

            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'vacancy_limit' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'priority' => [
                'required',
                'integer',
                'min:1',
            ],

            'benefits' => [
                'required',
                'array',
                'min:1',
            ],

            'benefits.*' => [
                'required',
                'string',
                'max:150',
            ],

            'active' => [
                'required',
                'boolean',
            ],
        ]);

        $membership = Membership::create($validated);

        return response()->json($membership, 201);
    }

    // GET /api/memberships
    // Devuelve todos los planes.
    public function index()
    {
        return response()->json(Membership::all(), 200);
    }

    // GET /api/memberships/{id}
    // Devuelve un plan específico.
    public function show($id)
    {
        $membership = Membership::findOrFail($id);

        return response()->json($membership, 200);
    }

    // PUT o PATCH /api/memberships/{id}
    // Modifica únicamente los campos enviados y válidos.
    public function update(Request $request, $id)
    {
        $membership = Membership::findOrFail($id);

        if ($request->has('code')) {
            $request->merge([
                'code' => strtolower(trim((string) $request->input('code'))),
            ]);
        }

        if ($request->has('name')) {
            $request->merge([
                'name' => trim((string) $request->input('name')),
            ]);
        }

        $validated = $request->validate([
            'code' => [
                'sometimes',
                'required',
                'string',
                'max:20',
                'in:basic,plus,premium',
                Rule::unique(Membership::class, 'code')
                    ->ignore($membership->getKey(), '_id'),
            ],

            'name' => [
                'sometimes',
                'required',
                'string',
                'max:100',
            ],

            'price' => [
                'sometimes',
                'required',
                'numeric',
                'min:0',
            ],

            'vacancy_limit' => [
                'sometimes',
                'nullable',
                'integer',
                'min:0',
            ],

            'priority' => [
                'sometimes',
                'required',
                'integer',
                'min:1',
            ],

            'benefits' => [
                'sometimes',
                'required',
                'array',
                'min:1',
            ],

            'benefits.*' => [
                'required',
                'string',
                'max:150',
            ],

            'active' => [
                'sometimes',
                'required',
                'boolean',
            ],
        ]);

        $membership->update($validated);

        return response()->json($membership, 200);
    }

    // DELETE /api/memberships/{id}

    // Elimina un plan.
    public function destroy($id)
    {
        $membership = Membership::findOrFail($id);

        $membership->delete();

        return response()->json([
            'message' => 'Plan eliminado correctamente.',
        ], 200);
    }
}