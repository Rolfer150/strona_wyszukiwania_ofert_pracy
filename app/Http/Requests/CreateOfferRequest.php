<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOfferRequest extends FormRequest
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
            'name' => ['required', 'unique:offers', 'max:64'],
            'salary' => ['nullable', 'numeric'],
            'payment' => ['nullable'],
            'vacancy' => ['nullable'],
            'description' => ['nullable'],
            'tasks' => ['nullable'],
            'expectancies' => ['nullable'],
            'additionals' => ['nullable'],
            'assurances' => ['nullable'],
            'image_path' => ['nullable'],
        ];
    }
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        return array_merge($validated, [
            'category_id' => $this->category_id,
            'employment' => $this->employment,
            'contract' => $this->contract,
            'work_mode' => $this->work_mode,
        ]);
    }
}
