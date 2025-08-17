<?php

namespace Modules\Refund\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Order\Models\Order;
use Modules\Refund\Events\RefundRequested;
use Modules\Refund\Events\RefundUpdate;
use Modules\User\Models\User;
use Modules\Vendor\Facades\Shop;

class Refund extends Model
{
    use HasUuids;
    
    protected $table = 'refunds';

    public $guarded = [];

    protected $casts = [
        'images' => 'json',
    ];

    protected $dispatchesEvents = [
        'created' => RefundRequested::class,
        'updated' => RefundUpdate::class,
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function refund_policy(): BelongsTo
    {
        return $this->belongsTo(RefundPolicy::class, 'refund_policy_id');
    }

    public function refund_reason(): BelongsTo
    {
        return $this->belongsTo(RefundReason::class, 'refund_reason_id');
    }
}
