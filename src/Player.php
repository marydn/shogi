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
    private bool $isWhite;
    private array $pieces;

    public function __construct(bool $isWhite = false)
    {
        $this->isWhite = $isWhite;

        $this->resetPieces();
    }

    public function pieces(): array
    {
        return $this->pieces;
    }

    private function resetPieces(): void
    {
        $this->pieces = array(
            new King(),
            new GoldGeneral(), new GoldGeneral(),
            new SilverGeneral(), new SilverGeneral(),
            new Knight(), new Knight(),
            new Lance(), new Lance(),
            new Bishop(),
            new Rook(),
        );

        for ($i = 1; $i <= Board::LIMIT_X; $i++) {
            $this->pieces[] = new Pawn();
        }
    }
}