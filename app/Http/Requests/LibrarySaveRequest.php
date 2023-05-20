<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LibrarySaveRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'temperature' => ['required', 'numeric', 'between:0.05,1'],
        ];
    }

    public function messages()
    {
        return [
            "temperature.required" => "Creativity is required",
        ];
    }
}
