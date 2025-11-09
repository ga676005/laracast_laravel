<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'employer_id' => ['required', 'exists:employers,employer_id'],
            'salary_usd' => ['required', 'numeric', 'min:0'],
            'salary_twd' => ['required', 'numeric', 'min:0'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => __('validation.attributes.title'),
            'employer_id' => __('validation.attributes.employer_id'),
            'salary_usd' => __('validation.attributes.salary_usd'),
            'salary_twd' => __('validation.attributes.salary_twd'),
        ];
    }
}
