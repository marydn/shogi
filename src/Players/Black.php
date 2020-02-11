<?php

declare(strict_types=1);

namespace Shogi\Players;

final class Black implements PlayerInterface
{
    public function isWhite(): bool
    {
        return false;
    }
}