<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $fillable = ['template_id', 'title', 'color', 'order', 'has_ratings'];

    protected $casts = [
        'has_ratings' => 'boolean',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function subsections(): HasMany
    {
        return $this->hasMany(Subsection::class)->orderBy('order');
    }

    public function ratingColumns(): HasMany
    {
        return $this->hasMany(RatingColumn::class)->orderBy('order');
    }
}
