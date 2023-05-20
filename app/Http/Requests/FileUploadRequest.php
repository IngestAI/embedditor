<?php

namespace App\Http\Requests;

use App\Models\LibraryFile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class FileUploadRequest extends FormRequest
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
            'library_id' => ['required', 'exists:libraries,id'],
            'file' => ['required', 'max:100000000', 'mimes:txt,csv,pdf']
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'File is required',
            'file.max' => 'Max file size is 100M bytes',
            'file.mimes' => "File can be txt or csv or pdf format",
        ];
    }

    public function passedValidation()
    {
        do {
            $fileKey = Str::random(rand(32, 64));
            $checkKey = LibraryFile::where('file_key', $fileKey)->first();
        } while (!empty($checkKey->id));

        $originalName = request()->file('file')->getClientOriginalName();

        $this->merge([
            'file_key' => $fileKey,
            'original_name' => $originalName,
            'filename' => time() . $originalName,
            'raw_content' => request()->file('file')->get(),
        ]);
    }
}
