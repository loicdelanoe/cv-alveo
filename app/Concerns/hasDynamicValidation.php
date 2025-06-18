<?php

namespace App\Concerns;

use App\Models\BlockType;
use App\Models\CollectionType;
use Illuminate\Http\Request;

trait hasDynamicValidation
{
    public function validateBlock(Request $request, BlockType|CollectionType $type)
    {
        [$rules, $attributes] = $this->generateRules($type);

        return $request->validate($rules, [], $attributes);
    }

    public function generateRules(BlockType|CollectionType $type): array
    {
        $rules = [];
        $attributes = [];

        foreach ($type['fields'] as $field) {
            $fieldName = 'content.'.$field['name'];

            $fieldRules = $field['validation'] ?? [];

            $fieldRules = implode('|', $fieldRules);

            // Rename content.fieldName to fieldName
            $attributes[$fieldName] = $field['name'];

            // Push the rules to the rules array
            $rules[$fieldName] = $fieldRules;
        }

        return [$rules, $attributes];
    }
}
