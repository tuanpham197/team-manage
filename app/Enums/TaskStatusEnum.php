<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TaskStatusEnum extends Enum
{
    public const OPEN = 1;

    public const PROCESSING = 2;

    public const REVIEW = 3;

    public const DONE = 4;
}
