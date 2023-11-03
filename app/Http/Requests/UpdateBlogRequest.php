<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
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
            'slug'          => [
                'string',
                'max:255',
                Rule::unique('blogs')->ignore($this->blog)
            ],
            'title'         => 'string|max:255',
            'short_desc'    => 'string',
            'image'         => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'content'       => 'string',
        ];
    }
}
