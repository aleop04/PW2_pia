<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterCompanyRequest;
use App\Http\Requests\RegisterStudentRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use MongoDB\Driver\Exception\BulkWriteException;

// Se conserva la ubicación del controlador existente; ahora utiliza sesiones web.
class AuthController extends Controller
{
    public function registerStudent(RegisterStudentRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = $this->createUser([
            'first_name' => $data['first_name'],
            'paternal_last_name' => $data['paternal_last_name'],
            'maternal_last_name' => $data['maternal_last_name'],
            'birth_date' => $data['birth_date'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'student',
        ]);

        return $this->startSession($request, $user);
    }

    public function registerCompany(RegisterCompanyRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = $this->createUser([
            'company_name' => $data['company_name'],
            'rfc' => $data['rfc'],
            'sector' => $data['sector'],
            'custom_sector' => $data['sector'] === 'other' ? $data['custom_sector'] : null,
            'state' => $data['state'],
            'city' => $data['city'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'company',
        ]);

        return $this->startSession($request, $user);
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Laravel busca el usuario y compara la contraseña con el hash guardado.
        $authenticated = Auth::guard('web')->attempt([
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => ['student', 'company'],
        ]);

        if (! $authenticated) {
            throw ValidationException::withMessages([
                'email' => 'Correo electrónico o contraseña incorrectos.',
            ]);
        }

        $request->session()->regenerate();

        // Siempre va al inicio de su rol, incluso si intentó abrir una URL del otro rol.
        $role = Auth::guard('web')->user()->role;

        return redirect()->route($role.'.home');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Sesión cerrada correctamente.');
    }

    private function startSession(Request $request, User $user): RedirectResponse
    {
        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect()->route($user->role.'.home');
    }

    private function createUser(array $data): User
    {
        try {
            return User::create($data);
        } catch (BulkWriteException $exception) {
            // El índice único también evita duplicados en dos registros simultáneos.
            if ($exception->getCode() === 11000) {
                throw ValidationException::withMessages([
                    'email' => 'Ya existe una cuenta con este correo electrónico.',
                ]);
            }

            throw $exception;
        }
    }
}
