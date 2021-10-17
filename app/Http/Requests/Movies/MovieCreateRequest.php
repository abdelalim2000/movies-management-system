<?php

namespace App\Http\Requests\Movies;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MovieCreateRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:3', Rule::unique('movies', 'title')],
            'slug' => ['required', 'string', 'min:3', Rule::unique('movies', 'slug')],
            'description' => ['required', 'string', 'min:3'],
            'video' => ['required', 'url'],
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'paid' => ['sometimes'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png']
        ];
    }

    public function prepareForValidation()
    {
        if ($this->paid == null) {
            $this->request->remove('paid');
        }
    }
}
