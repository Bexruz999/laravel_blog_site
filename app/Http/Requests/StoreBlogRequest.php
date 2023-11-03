<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'slug'          => 'required|string|max:255|unique:blogs',
            'title'         => 'required|string|max:255',
            'short_desc'    => 'required|string',
            'content'       => 'required|string',
            'image'         => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }
}
