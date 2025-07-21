<?php

namespace Modules\Refund\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notification\Enums\EventType;
use Modules\Notification\Traits\OrderSmsTrait;
use Modules\Notification\Traits\SmsTrait;
use Modules\Refund\Events\RefundUpdate;

class SendRefundUpdateNotification implements ShouldQueue
{
    use OrderSmsTrait;
    use SmsTrait;

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(RefundUpdate $event)
    {
        $refund = $event->refund;
        $order = $refund->order;
        if ($order->parent_id) {
            return;
        }
        $emailReceiver = $this->getWhichUserWillGetEmail(EventType::ORDER_REFUND, $event->refund->order->language);

        if ($emailReceiver['customer'] && $refund->customer()) {
            $refund->customer->notify(new RefundUpdate($refund, 'customer'));
        }

        if ($emailReceiver['admin']) {
            $admins = $this->adminList();
            foreach ($admins as $admin) {
                $admin->notify(new RefundUpdate($refund, 'admin'));
            }
        }
    }
}
