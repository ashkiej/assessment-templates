<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RatingColumn extends Model
{
    protected $fillable = ['section_id', 'name', 'max_rating', 'order'];

    protected $casts = [
        'max_rating' => 'integer',
        'order' => 'integer',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function getRatingOptionsAttribute()
    {
        $options = range(1, $this->max_rating);
        $options[] = 'NA';
        return $options;
    }
}
