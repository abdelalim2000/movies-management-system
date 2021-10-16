<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:5', 'max:75', Rule::unique('categories', 'name')->ignore($this->category)],
            'slug' => ['required', 'string', 'min:5', 'max:75', Rule::unique('categories', 'slug')->ignore($this->category)],
            'parent_id' => ['sometimes', 'integer', Rule::exists('categories', 'id')],
        ];
    }

    public function prepareForValidation()
    {
        if ($this->parent_id == null) {
            $this->request->remove('parent_id');
        }
    }
}
