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
            'name' => ['required', 'string', 'max:255'],
            'temperature' => ['required', 'numeric', 'between:0.05,1'],
            'chunk_size' => ['required', 'numeric', 'between:1000,2000'],
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Library name is required",
            "temperature.required" => "Creativity is required",
            'chunk_size.required' => "Detalization is required",
        ];
    }
}
