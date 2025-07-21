<?php

namespace Modules\Refund\Enums;

use BenSampo\Enum\Enum;

/**
 * Class RoleType
 */
final class RefundPolicyTarget extends Enum
{
    public const VENDOR = 'vendor';

    public const CUSTOMER = 'customer';
}
