<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MembershipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('web')?->role === 'admin';
    }

    protected function prepareForValidation(): void
    {
        if (is_string($this->input('benefits_text'))) {
            $this->merge(['benefits' => array_values(array_filter(array_map('trim', preg_split('/\R/', $this->input('benefits_text')))))]);
        }
    }

    public function rules(): array
    {
        $required = $this->isMethod('post') ? 'required' : 'sometimes';

        return [
            'code' => $this->isMethod('post')
                ? ['required', 'string', 'max:40', 'regex:/^[a-z][a-z0-9_-]*$/', Rule::unique('memberships', 'code')]
                : ['prohibited'],
            'name' => [$required, 'filled', 'string', 'max:80'],
            'price' => [$required, 'numeric', 'decimal:0,2', 'min:0', 'max:999999.99'],
            'vacancy_limit' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'priority' => [$required, 'integer', 'min:1', 'max:1000'],
            'benefits' => [$required, 'array', 'min:1', 'max:20'],
            'benefits.*' => ['required', 'string', 'max:200'],
            'active' => [$required, 'boolean'],
        ];
    }
}
