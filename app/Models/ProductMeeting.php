<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductMeeting extends Pivot
{

    protected $table = 'meeting_product';

    protected $fillable = [
        'notes',
        'requested',
        'sent',
        'follow_up',
        'not_needed',
        'requested_at',
        'sent_at',
        'follow_up_at',
        'buy_doc_url'
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
