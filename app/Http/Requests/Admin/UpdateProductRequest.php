<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['nullable', 'string', 'max:255'],
            'caption'     => ['required', 'string', 'max:5000'],
            'images'      => ['nullable', 'array'],
            'images.*'    => ['image', 'mimes:jpeg,jpg,png,webp', 'max:3072'],
            'is_active'   => ['boolean'],
            'sort_order'  => ['integer', 'min:0', 'max:9999'],
        ];
    }
}
