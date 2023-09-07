<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class MessageTypeEnum extends Enum
{
    public const TEXT = 1;

    public const IMAGE = 2;

    public const VOICE = 3;
}
