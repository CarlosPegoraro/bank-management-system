<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'number' => ['required', 'string', 'max:16'],
            'owner' => ['required', 'string', 'max:255'],
            'bank' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'validateDay' => ['required'],
            'paymentDay' => ['required'],
        ];
    }
}
