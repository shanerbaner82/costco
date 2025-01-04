<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductMeeting extends Pivot
{
    protected $fillable = [
        'notes',
        'requested',
        'sent',
        'follow_up',
        'not_needed',
        'requested_at',
        'sent_at',
        'follow_up_at',
    ];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


}
