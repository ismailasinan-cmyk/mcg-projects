<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrackingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'nullable|date',
            'company' => 'required|string|max:255',
            'client' => 'required|string|max:255',
            'project' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'lga' => 'nullable|string|max:255',
            'cost' => 'nullable|numeric',
            'activity' => 'nullable|string',
            'progress' => 'nullable|string',
            'responsible' => 'nullable|string|max:255',
            'status' => 'required|in:moving_forward,in_progress,no_progress',
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png,gif,webp,svg,bmp|max:102400',
            'delete_documents' => 'nullable|array',
        ];
    }
}
