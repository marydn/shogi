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

        $this->initialInventory();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function isWhite(): bool
    {
        return $this->isWhite;
    }

    private function initialInventory(): array
    {
        $bigPieces = [
            new King($this->isWhite),
            new Lance($this->isWhite),
            new Lance($this->isWhite),
            new Knight($this->isWhite),
            new Knight($this->isWhite),
            new SilverGeneral($this->isWhite),
            new SilverGeneral($this->isWhite),
            new GoldGeneral($this->isWhite),
            new GoldGeneral($this->isWhite),

            new Bishop($this->isWhite),
            new Rook($this->isWhite),
        ];

        $pawns = array_fill(0, 9, new Pawn($this->isWhite));

        return [...$bigPieces, ...$pawns];
    }

    public function __toString()
    {
        return $this->name();
    }
}