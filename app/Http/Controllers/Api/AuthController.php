<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterStudentRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Storage;
use Throwable;

class AuthController extends Controller
{
    public function registerStudent(
        RegisterStudentRequest $request
    ): JsonResponse {
        Log::info('Inicio del registro de estudiante', [
            'email' => $request->email,
        ]);

        $user = null;
        $kardexPath = null;

        try {
            $data = $request->validated();

            $user = User::create([
                'first_name' => $data['first_name'],
                'paternal_last_name' => $data['paternal_last_name'],
                'maternal_last_name' => $data['maternal_last_name'],
                'birth_date' => $data['birth_date'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'student',
            ]);

            $kardexPath = $request
                ->file('kardex')
                ->store('kardex', 'local');

            StudentProfile::create([
                'user_id' => (string) $user->id,
                'kardex_path' => $kardexPath,
                'kardex_original_name' =>
                    $request->file('kardex')->getClientOriginalName(),
            ]);

            $token = $user
                ->createToken('student-api-token')
                ->plainTextToken;

            Log::info(
                'Registro de estudiante finalizado correctamente',
                [
                    'user_id' => (string) $user->id,
                ]
            );

            return response()->json([
                'message' => 'Estudiante registrado correctamente.',
                'token' => $token,
                'user' => $user,
            ], 201);

        } catch (Throwable $exception) {

            if ($kardexPath) {
                Storage::disk('local')->delete($kardexPath);
            }

            if ($user) {
                StudentProfile::where(
                    'user_id',
                    (string) $user->id
                )->delete();

                $user->delete();
            }

            Log::error('Error durante el registro de estudiante', [
                'error' => $exception->getMessage(),
            ]);

            return response()->json([
                'message' =>
                    'No fue posible registrar al estudiante.',
            ], 500);
        }
    }

    public function login(
        LoginRequest $request
    ): JsonResponse {
        Log::info('Inicio del proceso de login', [
            'email' => $request->email,
        ]);

        $data = $request->validated();

        $user = User::where(
            'email',
            $data['email']
        )->first();

        if (
            ! $user ||
            ! Hash::check($data['password'], $user->password)
        ) {
            Log::warning(
                'Intento de login con credenciales incorrectas',
                [
                    'email' => $request->email,
                ]
            );

            return response()->json([
                'message' =>
                    'Correo electrónico o contraseña incorrectos.',
            ], 401);
        }

        try {
            $token = $user
                ->createToken('api-token')
                ->plainTextToken;

            Log::info('Login finalizado correctamente', [
                'user_id' => (string) $user->id,
                'role' => $user->role,
            ]);

            return response()->json([
                'message' => 'Inicio de sesión exitoso.',
                'token' => $token,
                'user' => $user,
            ]);

        } catch (Throwable $exception) {

            Log::error('Error durante el login', [
                'user_id' => (string) $user->id,
                'error' => $exception->getMessage(),
            ]);

            return response()->json([
                'message' =>
                    'Ocurrió un error durante el inicio de sesión.',
            ], 500);
        }
    }

    public function user(
        Request $request
    ): JsonResponse {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

    public function logout(
        Request $request
    ): JsonResponse {
        Log::info('Inicio del proceso de logout', [
            'user_id' => (string) $request->user()->id,
        ]);

        try {
            $request->user()
                ->currentAccessToken()
                ->delete();

            Log::info('Logout finalizado correctamente', [
                'user_id' => (string) $request->user()->id,
            ]);

            return response()->json([
                'message' =>
                    'Sesión cerrada correctamente.',
            ]);

        } catch (Throwable $exception) {

            Log::error('Error durante el logout', [
                'user_id' => (string) $request->user()->id,
                'error' => $exception->getMessage(),
            ]);

            return response()->json([
                'message' =>
                    'No fue posible cerrar la sesión.',
            ], 500);
        }
    }
}