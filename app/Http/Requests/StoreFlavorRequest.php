<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFlavorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:flavors,name'],
            'description' => ['nullable', 'string'],
            'is_available' => ['sometimes', 'boolean'],
        ];
    }
}
