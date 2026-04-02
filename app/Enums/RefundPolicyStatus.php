<?php

declare(strict_types=1);

namespace Modules\Refund\Enums;

enum RefundPolicyStatus: string
{
    case Approved = 'approved';
    case Pending = 'pending';
}
