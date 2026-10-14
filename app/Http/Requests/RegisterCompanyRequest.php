<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        foreach (['company_name', 'rfc', 'sector', 'custom_sector', 'state', 'city', 'email'] as $field) {
            if (is_string($this->input($field))) {
                $this->merge([$field => trim($this->input($field))]);
            }
        }

        if (is_string($this->input('email'))) {
            $this->merge(['email' => strtolower($this->input('email'))]);
        }

        if (is_string($this->input('rfc'))) {
            $this->merge(['rfc' => mb_strtoupper($this->input('rfc'))]);
        }

        $this->merge(['_account_type' => 'company']);
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:150'],
            'rfc' => ['required', 'string', 'regex:/^[A-ZÑ&]{3}[0-9]{6}[A-Z0-9]{3}$/u'],
            'sector' => ['required', Rule::in([
                'technology', 'health', 'education', 'finance', 'engineering',
                'business', 'marketing', 'sales', 'rh', 'law', 'architecture',
                'communication', 'tourism', 'manufacturing', 'construction',
                'logistics', 'energy', 'agriculture', 'science', 'government', 'other',
            ])],
            'custom_sector' => ['exclude_unless:sector,other', 'required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
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
            'company_name' => 'nombre de la empresa',
            'rfc' => 'RFC',
            'sector' => 'sector',
            'custom_sector' => 'otro sector',
            'state' => 'estado',
            'city' => 'ciudad',
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
            'rfc.regex' => 'El RFC empresarial debe tener 12 caracteres: 3 letras, 6 números y 3 caracteres alfanuméricos. Ejemplo: ABC010203AB1.',
            'sector.in' => 'Selecciona uno de los sectores disponibles.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'email.unique' => 'Ya existe una cuenta con este correo electrónico.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe incluir al menos una letra mayúscula.',
            'password.numbers' => 'La contraseña debe incluir un número.',
        ];
    }
}
