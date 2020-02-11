<?php

declare(strict_types=1);

namespace Shogi\Players;

final class White implements PlayerInterface
{
    public function isWhite(): bool
    {
        return true;
    }
}