<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Shared\Collection;

final class MovesList extends Collection
{
    protected function getType(): string
    {
        return Move::class;
    }
}