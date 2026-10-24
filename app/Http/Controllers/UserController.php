<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // Normaliza texto antes de validar y guardar
    private function normalizeUserFields(Request $request): void
    {
        $textFields = [
            'first_name',
            'paternal_last_name',
            'maternal_last_name',
            'company_name',
            'rfc',
            'sector',
            'custom_sector',
            'state',
            'city',
            'email',
            'role',
        ];

        foreach ($textFields as $field) {
            if ($request->has($field) && is_string($request->input($field))) {
                $request->merge([
                    $field => trim($request->input($field)),
                ]);
            }
        }

        if ($request->has('email')) {
            $request->merge([
                'email' => strtolower($request->input('email')),
            ]);
        }

        if ($request->has('rfc')) {
            $request->merge([
                'rfc' => mb_strtoupper($request->input('rfc')),
            ]);
        }

        if ($request->has('role')) {
            $request->merge([
                'role' => strtolower($request->input('role')),
            ]);
        }
    }

        // Rechaza campos que no pertenecen al tipo de usuario.
    private function rejectUnexpectedFields(
        Request $request,
        array $allowedFields
    ): void {
        $unexpectedFields = array_diff(
            array_keys($request->all()),
            $allowedFields
        );

        if ($unexpectedFields === []) {
            return;
        }

        $errors = [];

        foreach ($unexpectedFields as $field) {
            $errors[$field] = [
                "El campo {$field} no está permitido para este tipo de usuario.",
            ];
        }

        throw ValidationException::withMessages($errors);
    }

    // POST /api/users
    // Crea solamente estudiantes o empresas.

    public function store(Request $request)
    {
        $this->normalizeUserFields($request);

        $role = $request->validate([
            'role' => [
                'required',
                'string',
                'in:student,company',
            ],
        ])['role'];

        $allowedFields = [
            'role',
            'email',
            'password',
            'password_confirmation',
        ];
        
        if ($role === 'student') {
            $allowedFields = array_merge($allowedFields, [
                'first_name',
                'paternal_last_name',
                'maternal_last_name',
                'birth_date',
                'phone',
            ]);
        }
        
        if ($role === 'company') {
            $allowedFields = array_merge($allowedFields, [
                'company_name',
                'rfc',
                'sector',
                'custom_sector',
                'state',
                'city',
                
            ]);
        }
        
        $this->rejectUnexpectedFields($request, $allowedFields);


        $rules = [
            'role' => [
                'required',
                'string',
                'in:student,company',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class, 'email'),
            ],

            'password' => [
                'required',
                'string',
                'max:72',
                'confirmed',
                Password::min(8)->numbers(),
                'regex:/[A-Z]/',
            ],
        ];

        if ($role === 'student') {
            $rules = array_merge($rules, [
                'first_name' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'paternal_last_name' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'maternal_last_name' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'birth_date' => [
                    'required',
                    'date_format:Y-m-d',
                    'before:today',
                ],

                'phone' => [
                    'required',
                    'string',
                    'regex:/^[0-9]{10}$/',
                ],
            ]);
        }

        if ($role === 'company') {
            $rules = array_merge($rules, [
                'company_name' => [
                    'required',
                    'string',
                    'max:150',
                ],

                'rfc' => [
                    'required',
                    'string',
                    'regex:/^[A-ZÑ&]{3}[0-9]{6}[A-Z0-9]{3}$/u',
                ],

                'sector' => [
                    'required',
                    Rule::in([
                        'technology',
                        'health',
                        'education',
                        'finance',
                        'engineering',
                        'business',
                        'marketing',
                        'sales',
                        'rh',
                        'law',
                        'architecture',
                        'communication',
                        'tourism',
                        'manufacturing',
                        'construction',
                        'logistics',
                        'energy',
                        'agriculture',
                        'science',
                        'government',
                        'other',
                    ]),
                ],

                'custom_sector' => [
                    'exclude_unless:sector,other',
                    'required',
                    'string',
                    'max:100',
                ],

                'state' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'city' => [
                    'required',
                    'string',
                    'max:100',
                ],
            ]);
        }

        $validated = $request->validate($rules);

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    // GET /api/users
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    // GET /api/users/{id}
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user, 200);
    }

    // PUT o PATCH /api/users/{id}
    // Nunca permite cambiar el rol mediante esta ruta

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->normalizeUserFields($request);

        $allowedFields = [
            'email',
            'password',
            'password_confirmation',
        ];

        if ($user->role === 'student') {
            $allowedFields = array_merge($allowedFields, [
                'first_name',
                'paternal_last_name',
                'maternal_last_name',
                'birth_date',
                'phone',
            ]);

        }
        if ($user->role === 'company') {
            $allowedFields = array_merge($allowedFields, [
                'company_name',
                'rfc',
                'sector',
                'custom_sector',
                'state',
                'city',
            ]);
        }

        $this->rejectUnexpectedFields($request, $allowedFields);    

        $rules = [
            'role' => [
                'prohibited',
            ],

            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class, 'email')
                    ->ignore($user->getKey(), '_id'),
            ],

            'password' => [
                'sometimes',
                'required',
                'string',
                'max:72',
                'confirmed',
                Password::min(8)->numbers(),
                'regex:/[A-Z]/',
            ],
        ];

        if ($user->role === 'student') {
            $rules = array_merge($rules, [
                'first_name' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:100',
                ],

                'paternal_last_name' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:100',
                ],

                'maternal_last_name' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:100',
                ],

                'birth_date' => [
                    'sometimes',
                    'required',
                    'date_format:Y-m-d',
                    'before:today',
                ],

                'phone' => [
                    'sometimes',
                    'required',
                    'string',
                    'regex:/^[0-9]{10}$/',
                ],
            ]);
        }

        if ($user->role === 'company') {
            $rules = array_merge($rules, [
                'company_name' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:150',
                ],

                'rfc' => [
                    'sometimes',
                    'required',
                    'string',
                    'regex:/^[A-ZÑ&]{3}[0-9]{6}[A-Z0-9]{3}$/u',
                ],

                'sector' => [
                    'sometimes',
                    'required',
                    Rule::in([
                        'technology',
                        'health',
                        'education',
                        'finance',
                        'engineering',
                        'business',
                        'marketing',
                        'sales',
                        'rh',
                        'law',
                        'architecture',
                        'communication',
                        'tourism',
                        'manufacturing',
                        'construction',
                        'logistics',
                        'energy',
                        'agriculture',
                        'science',
                        'government',
                        'other',
                    ]),
                ],

                'custom_sector' => [
                    'exclude_unless:sector,other',
                    'required_if:sector,other',
                    'nullable',
                    'string',
                    'max:100',
                ],

                'state' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:100',
                ],

                'city' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:100',
                ],
            ]);
        }

        $validated = $request->validate($rules);

        if (
            array_key_exists('sector', $validated) &&
            $validated['sector'] !== 'other'
        ) {
            $validated['custom_sector'] = null;
        }

        $user->update($validated);

        return response()->json($user, 200);
    }

    // DELETE /api/users/{id}
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado correctamente.',
        ], 200);
    }
}