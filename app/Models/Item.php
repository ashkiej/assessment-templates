<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    protected $fillable = ['subsection_id', 'name', 'order', 'has_ratings'];

    protected $casts = [
        'has_ratings' => 'boolean',
    ];

    public function subsection(): BelongsTo
    {
        return $this->belongsTo(Subsection::class);
    }
}
