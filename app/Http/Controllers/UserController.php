<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // POST: Crear un usuario (Estudiante o Empresa)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|string|in:student,company',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
            
            // Validaciones condicionales para Estudiantes
            'first_name' => 'required_if:role,student|nullable|string|max:255',
            'paternal_last_name' => 'required_if:role,student|nullable|string|max:255',
            'maternal_last_name' => 'nullable|string|max:255',
            'birth_date' => 'required_if:role,student|nullable|date',

            // Validaciones condicionales para Empresas
            'company_name' => 'required_if:role,company|nullable|string|max:255',
            'rfc' => 'required_if:role,company|nullable|string|max:13',
            'sector' => 'required_if:role,company|nullable|string|max:255',
            'state' => 'required_if:role,company|nullable|string|max:255',
            'city' => 'required_if:role,company|nullable|string|max:255',
        ]);

        // El cast 'hashed' en el modelo User encripta la contraseña automáticamente
        $user = User::create($validated);
        
        return response()->json($user, 201);
    }

    // GET: Obtener todos los usuarios
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    // GET: Obtener un solo usuario por ID
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }

    // PUT: Actualizar usuario
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'paternal_last_name' => 'sometimes|required|string|max:255',
            'maternal_last_name' => 'nullable|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,'.$id.',_id',
            'password' => 'sometimes|required|string|min:6',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'sometimes|required|string|max:255',
            'rfc' => 'sometimes|required|string|max:13',
            'sector' => 'sometimes|required|string|max:255',
            'state' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:255',
        ]);

        $user->update($validated);
        
        return response()->json($user, 200);
    }

    // DELETE: Eliminar usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return response()->json(['message' => 'Usuario eliminado'], 200);
    }
}