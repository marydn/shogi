<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Pieces\Bishop;
use Shogi\Pieces\GoldGeneral;
use Shogi\Pieces\King;
use Shogi\Pieces\Knight;
use Shogi\Pieces\Lance;
use Shogi\Pieces\Pawn;
use Shogi\Pieces\Rook;
use Shogi\Pieces\SilverGeneral;

final class Player
{
    private string $name;
    private bool $isWhite;

    public function __construct(string $name, bool $isWhite = false)
    {
        $this->name = $name;
        $this->isWhite = $isWhite;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function isWhite(): bool
    {
        return $this->isWhite;
    }

    public function __toString()
    {
        return $this->name();
    }
}