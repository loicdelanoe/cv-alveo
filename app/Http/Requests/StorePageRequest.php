<?php

namespace App\Http\Requests;

use App\Rules\Slug;
use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
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
            'status' => 'required|in:published,draft',
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', 'unique:pages,slug', new Slug],
            'blocks' => 'array',
            // 'blocks.*.id' => 'exists:blocks,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'og_type' => 'nullable|string|in:article,website,product,video,book,profile,place,event',
            'is_archive' => 'boolean',
            'collection_type_id' => 'nullable|exists:collection_types,id|integer',
        ];
    }
}
