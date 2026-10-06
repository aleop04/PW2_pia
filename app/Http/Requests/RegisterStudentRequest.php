<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => strtolower(trim((string) $this->email)),
            'first_name' => trim((string) $this->first_name),
            'paternal_last_name' => trim((string) $this->paternal_last_name),
            'maternal_last_name' => trim((string) $this->maternal_last_name),
        ]);
    }

    public function rules(): array
    {
        return [
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
                'regex:/^\+?[0-9]{10,15}$/',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers(),
            ],

            'kardex' => [
                'required',
                'file',
                'mimes:pdf',
                'max:5120',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' =>
                'El nombre es obligatorio.',

            'paternal_last_name.required' =>
                'El apellido paterno es obligatorio.',

            'maternal_last_name.required' =>
                'El apellido materno es obligatorio.',

            'birth_date.required' =>
                'La fecha de nacimiento es obligatoria.',

            'birth_date.date_format' =>
                'La fecha de nacimiento debe tener el formato AAAA-MM-DD.',

            'birth_date.before' =>
                'La fecha de nacimiento debe ser anterior a hoy.',

            'phone.required' =>
                'El número de teléfono es obligatorio.',

            'phone.regex' =>
                'El número de teléfono no tiene un formato válido.',

            'email.required' =>
                'El correo electrónico es obligatorio.',

            'email.email' =>
                'El correo electrónico no tiene un formato válido.',

            'email.unique' =>
                'Ya existe una cuenta con este correo electrónico.',

            'password.required' =>
                'La contraseña es obligatoria.',

            'password.confirmed' =>
                'Las contraseñas no coinciden.',

            'kardex.required' =>
                'El kardex es obligatorio.',

            'kardex.file' =>
                'El kardex debe ser un archivo válido.',

            'kardex.mimes' =>
                'El kardex debe estar en formato PDF.',

            'kardex.max' =>
                'El kardex no puede superar los 5 MB.',
        ];
    }
}