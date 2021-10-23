<?php

namespace App\Http\Requests\Reviews;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->id() === $this->review->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'review' => ['required', 'string', 'min:3'],
            'slug' => ['required', 'string', Rule::unique('reviews', 'slug')->ignore($this->review)],
            'rate' => ['required', 'integer', 'between:1,5'],
            'movie_id' => ['required', 'exists:movies,id'],
            'user_id' => ['required', 'exists:users,id'],
            'approved' => 'sometimes'
        ];
    }

    public function prepareForValidation()
    {
        if ($this->approved === null) {
            $this->request->remove('approved');
        }
    }
}
