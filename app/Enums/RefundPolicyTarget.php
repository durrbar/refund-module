<?php

declare(strict_types=1);

namespace Modules\Refund\Enums;

enum RefundPolicyTarget: string
{
    case Vendor = 'vendor';
    case Customer = 'customer';
}
