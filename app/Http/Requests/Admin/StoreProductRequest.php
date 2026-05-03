<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'caption'    => ['required', 'string', 'max:2000'],
            'image'      => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'is_active'  => ['boolean'],
            'sort_order' => ['integer', 'min:0', 'max:9999'],
        ];
    }
}
