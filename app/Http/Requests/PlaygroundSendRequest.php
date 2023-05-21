<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaygroundSendRequest extends FormRequest
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
            'q' => ['required', 'max:255'],
            'model_id' => ['required', 'exists:provider_models,id'],
        ];
    }

    public function messages()
    {
        return [
            'q.required' => 'The query is required',
            'model_id.exists' => 'The model is wrong',
        ];
    }
}
