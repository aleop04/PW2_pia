<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // POST: Crear un usuario
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'email' => 'required|email', // Mongo no valida unique en request directo fácilmente, lo hacemos manual
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:student,company',
        ]);

        // Verificar si el correo ya existe
        if (User::where('email', $validated['email'])->exists()) {
            return response()->json(['message' => 'El correo ya está registrado'], 400);
        }

        $validated['password'] = Hash::make($validated['password']);
        
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    // GET: Obtener todos los usuarios
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    // PUT: Actualizar usuario
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        if ($request->has('password')) {
            $request->merge(['password' => Hash::make($request->password)]);
        }
        
        $user->update($request->all());
        return response()->json($user, 200);
    }

    // DELETE: Eliminar usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado'], 200);
    }
            // GET: Obtener un solo usuario por ID
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }
}