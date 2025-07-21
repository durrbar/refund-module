<?php

namespace Modules\Refund\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Refund\Models\Refund;

class RefundApproved
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    public $refund;

    /**
     * Create a new event instance.
     */
    public function __construct(Refund $refund)
    {
        $this->refund = $refund;
    }
}
