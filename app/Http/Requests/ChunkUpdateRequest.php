<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChunkUpdateRequest extends FormRequest
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
            //
        ];
    }

    public function passedValidation()
    {
        $this->images = $this->links = [];
        foreach (($this->attachments ?? []) as $chunk => $attachment) {
            foreach (($attachment['images'] ?? []) as $index => $image) {
                if (empty($image)) continue;
                $this->images[$chunk][$index] = $image;
            }
            foreach (($attachment['links'] ?? []) as $index => $link) {
                if (empty($link)) continue;
                $this->links[$chunk][$index] = $link;
            }
        }

        $this->merge([
            'images' => $this->images,
            'links' => $this->links,
        ]);
    }
}
