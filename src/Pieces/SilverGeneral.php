<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

final class SilverGeneral extends BasePiece implements PieceInterface
{
    const NAME = 'S';

    public function canMove(Board $board, Spot $from, Spot $to): bool
    {
        if ($to->pieceIsWhite() === $this->isWhite()) {
            return false;
        }
    }
}