<?php

declare(strict_types=1);

namespace Modules\Refund\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Refund\Models\Refund;

class RefundRequested
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public readonly Refund $refund) {}
}
