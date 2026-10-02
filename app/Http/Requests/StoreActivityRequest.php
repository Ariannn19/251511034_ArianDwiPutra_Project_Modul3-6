<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('activities', 'code')->ignore($this->route('activity')),
            ],
            'title'         => ['required', 'string', 'min:5', 'max:100'],
            'description'   => ['nullable', 'string', 'max:1000'],
            'activity_date' => ['required', 'date'],
            'category_id'   => ['required', 'exists:categories,id'],
            'status'        => ['required', Rule::in(['draft', 'published', 'completed', 'cancelled'])],
        ];
    }
}
