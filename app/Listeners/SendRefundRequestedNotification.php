<?php

declare(strict_types=1);

namespace Modules\Refund\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notification\Enums\EventType;
use Modules\Notification\Traits\OrderSmsTrait;
use Modules\Notification\Traits\SmsTrait;
use Modules\Refund\Events\RefundRequested;

class SendRefundRequestedNotification implements ShouldQueue
{
    use OrderSmsTrait;
    use SmsTrait;

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(RefundRequested $event)
    {
        $refund = $event->refund;
        $customer = $refund->customer;
        $order = $refund->order;
        $emailReceiver = $this->getWhichUserWillGetEmail(EventType::OrderRefund->value, $order->language);
        if ($emailReceiver['admin']) {
            $admins = $this->adminList();
            foreach ($admins as $admin) {
                $admin->notify(new RefundRequested($refund, 'admin'));
            }
        }
        if ($emailReceiver['customer']) {
            $customer->notify(new RefundRequested($refund, 'customer'));
        }
        $this->sendRefundRequestedSms($refund);
    }
}
