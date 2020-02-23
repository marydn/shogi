<?php

declare(strict_types=1);

namespace Shogi\ValueObject;

use Shogi\Shared\Enum;

/**
 * @method static NotationType simple()
 * @method static NotationType capture()
 * @method static NotationType drop()
 * @method static NotationType promoted()
 */
final class NotationType extends Enum
{
    public const SIMPLE     = '-';
    public const CAPTURE    = 'x';
    public const DROP       = '*';
    public const PROMOTED   = '+';
    public const UNPROMOTED = '=';

    protected function throwExceptionForInvalidValue($value): void
    {
        throw new \InvalidArgumentException(sprintf('The notation type <%s> is invalid', $value));
    }
}