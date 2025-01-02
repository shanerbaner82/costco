<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buyer extends Model
{
    /** @use HasFactory<\Database\Factories\BuyerFactory> */
    use HasFactory;

    protected $guarded = [];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class);
    }
}
