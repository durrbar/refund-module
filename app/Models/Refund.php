<?php

namespace Modules\Refund\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Refund\Events\RefundRequested;
use Modules\Refund\Events\RefundUpdate;

class Refund extends Model
{
    protected $table = 'refunds';

    public $guarded = [];

    protected $casts = [
        'images'   => 'json',
    ];

    protected $dispatchesEvents = [
        'created' => RefundRequested::class,
        'updated' => RefundUpdate::class,
    ];

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    /**
     * @return BelongsTo
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
    /**
     * @return BelongsTo
     */
    public function refund_policy(): BelongsTo
    {
        return $this->belongsTo(RefundPolicy::class, 'refund_policy_id');
    }
    /**
     * @return BelongsTo
     */
    public function refund_reason(): BelongsTo
    {
        return $this->belongsTo(RefundReason::class, 'refund_reason_id');
    }
}
