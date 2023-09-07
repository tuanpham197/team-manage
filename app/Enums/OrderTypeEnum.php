<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderTypeEnum extends Enum
{
    public const CREATED = 'CREATED';

    public const UPDATED = 'UPDATED';
}
