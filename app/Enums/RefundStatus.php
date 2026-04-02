<?php

declare(strict_types=1);

namespace Modules\Refund\Enums;

enum RefundStatus: string
{
    case Approved = 'approved';
    case Pending = 'pending';
    case Rejected = 'rejected';
    case Processing = 'processing';
}
