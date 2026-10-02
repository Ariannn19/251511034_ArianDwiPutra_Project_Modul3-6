<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'   => ['required', 'exists:categories,id'],
            'code'          => ['nullable', 'string', 'max:20'],
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'activity_date' => ['nullable', 'date'],
            'status'        => ['nullable', 'in:draft,published,completed,cancelled'],
            'capacity'      => ['nullable', 'integer', 'min:1'],
            'poster'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'], // Maksimal 2MB
        ];
    }
}
