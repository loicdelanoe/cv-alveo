<?php

namespace App\Http\Requests;

use App\Rules\Slug;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlockTypeRequest extends FormRequest
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
            'name' => 'required|string',
            'type' => ['required', 'string', 'unique:block_types', new Slug],
            'component' => 'nullable|string',
            'fields' => 'required|array',
            'fields.*.name' => 'required|string',
            'fields.*.type' => 'required|string',
            'fields.*.label' => 'required|string',
            'fields.*.validation' => 'array',
            'fields.*.repeaterFields' => 'exclude_unless:fields.*.type,repeater|required|array',
        ];
    }

    public function attributes(): array
    {
        return [
            'fields.*.name' => 'name',
            'fields.*.type' => 'type',
            'fields.*.label' => 'label',
        ];
    }
}
