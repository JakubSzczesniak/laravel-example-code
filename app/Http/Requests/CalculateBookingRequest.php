<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class CalculateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
        ];
    }
}
