<?php

namespace App\Http\Requests\Movies;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MovieUpdateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'min:3', Rule::unique('movies', 'title')->ignore($this->movie)],
            'slug' => ['required', 'string', 'min:3', Rule::unique('movies', 'slug')->ignore($this->movie)],
            'description' => ['required', 'string', 'min:3'],
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'paid' => ['sometimes'],
            'image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png']
        ];
    }

    public function prepareForValidation()
    {
        if ($this->paid == null) {
            $this->request->remove('paid');
        }

        if ($this->image == null) {
            $this->request->remove('image');
        }
    }
}
