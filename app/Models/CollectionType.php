<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CollectionType extends Model
{
    /** @use HasFactory<\Database\Factories\CollectionTypeFactory> */
    use HasFactory;

    protected $fillable = ['name', 'type', 'fields'];

    protected $casts = [
        'fields' => 'array',
    ];

    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class);
    }
}
