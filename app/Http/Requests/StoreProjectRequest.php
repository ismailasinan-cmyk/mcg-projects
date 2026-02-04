<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'state' => 'required|string',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'awarded_at' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:102400',
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255',
        ];
    }
}
