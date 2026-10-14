<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        foreach (['first_name', 'paternal_last_name', 'maternal_last_name', 'phone', 'email'] as $field) {
            if (is_string($this->input($field))) {
                $this->merge([$field => trim($this->input($field))]);
            }
        }

        if (is_string($this->input('email'))) {
            $this->merge(['email' => strtolower($this->input('email'))]);
        }

        $this->merge(['_account_type' => 'student']);
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'paternal_last_name' => ['required', 'string', 'max:100'],
            'maternal_last_name' => ['required', 'string', 'max:100'],
            'birth_date' => ['required', 'date_format:Y-m-d', 'before:today'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class, 'email')],
            'password' => [
                'bail', 'required', 'string', 'max:72', 'confirmed',
                Password::min(8)->numbers(),
                'regex:/[A-Z]/',
                // Bcrypt admite hasta 72 bytes, incluyendo letras con acentos.
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (strlen($value) > 72) {
                        $fail('La contraseña es demasiado larga. Utiliza una más corta.');
                    }
                },
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'nombre',
            'paternal_last_name' => 'apellido paterno',
            'maternal_last_name' => 'apellido materno',
            'birth_date' => 'fecha de nacimiento',
            'phone' => 'teléfono',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => 'El campo :attribute no puede superar :max caracteres.',
            'birth_date.date_format' => 'La fecha de nacimiento debe tener el formato AAAA-MM-DD.',
            'birth_date.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'phone.regex' => 'Escribe un número de México de 10 dígitos, sin espacios ni +52.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'email.unique' => 'Ya existe una cuenta con este correo electrónico.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe incluir al menos una letra mayúscula.',
            'password.numbers' => 'La contraseña debe incluir un número.',
        ];
    }
}
