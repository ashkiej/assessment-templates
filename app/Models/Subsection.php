<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subsection extends Model
{
    protected $fillable = ['section_id', 'title', 'order', 'has_ratings'];

    protected $casts = [
        'has_ratings' => 'boolean',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class)->orderBy('order');
    }
}
