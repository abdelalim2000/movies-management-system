<?php

namespace App\Http\Requests\Plans;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'name' => ['required', 'string', 'min:3', Rule::unique('plans', 'name')->ignore($this->plan)],
            'slug' => ['required', 'string', 'min:3', Rule::unique('plans', 'slug')->ignore($this->plan)],
            'price' => ['required', 'numeric'],
            'duration_months' => ['required', 'numeric']
        ];
    }
}
