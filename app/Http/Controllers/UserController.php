<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'paternal_last_name' => 'required|string|max:255',
            'maternal_last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:student,company',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string',
            'rfc' => 'nullable|string',
            'sector' => 'nullable|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
        ]);

        // El cast 'hashed' en el modelo User se encarga de encriptar la contraseña automáticamente
        $user = User::create($validated);
        return response()->json($user, 201);
    }

    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Validación para actualizaciones parciales (sección A y B)
        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'paternal_last_name' => 'sometimes|required|string|max:255',
            'maternal_last_name' => 'nullable|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,'.$id.',_id',
            'password' => 'sometimes|required|string|min:6',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);
        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado'], 200);
    }
}