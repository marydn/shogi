<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

final class GoldGeneral extends BasePiece implements PieceInterface
{
    const NAME = 'G';

    public function canMove(Board $board, Spot $from, Spot $to): bool
    {
        if ($to->pieceIsWhite() === $this->isWhite()) {
            return false;
        }
    }
}